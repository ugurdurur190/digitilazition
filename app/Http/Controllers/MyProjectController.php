<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectAffectedUnit;
use App\Models\ProjectAnswer;
use App\Models\ProjectCurrentProcess;
use App\Models\ProjectCurrentProcessAnswers;
use App\Models\ProjectQuestion;
use App\Models\ProjectWorkTeam;
use App\Models\User;
use App\Models\Unit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class MyProjectController extends Controller
{

   public function __construct()
   {
       $this->middleware('auth');

   }

   public function listMyProject()
    {
      $projects = Project::all();
      $users = User::all();
      return view('projects.my-project-list',["users" => $users, "projects" => $projects]);
    }


    public function viewMyProject($id)
    {
      $projects = Project::all()->find($id);
      $projectQuestion = ProjectQuestion::where('project_id',$id)->get();
      $answers = ProjectAnswer::where("project_id",$id)->get();
      $processes = ProjectCurrentProcess::where("project_id",$id)->get();
      $processAnswers = ProjectCurrentProcessAnswers::where("project_id",$id)->get();
      $affectedUnits = ProjectAffectedUnit::where("project_id",$id)->get();
      $users = User::all();
      $units = Unit::all();

      if(isset($projects)){
         return view('projects.my-project-view',["projectQuestion" => $projectQuestion, "answers" => $answers, "processes" => $processes, "processAnswers" => $processAnswers, "users" => $users, "projects" => $projects, "units" => $units, "affectedUnits" => $affectedUnits]);
      }
      else{
         return Redirect::to('my-projects/list')->with('warning', 'Böyle bir proje yok!');
      }
    }

    public function storeNewProjectQuestion(Request $request)
    {
        $projectQuestion = new ProjectQuestion;
        $projectQuestion->project_id = $request->project_id;
        $projectQuestion->question = $request->question;

        $projectQuestion->type=$request->type;
        if($projectQuestion->type=='radio_opt'){
            $projectQuestion->frm_option = implode(",",$request->radio);
        }
        elseif($projectQuestion->type=='check_opt'){
            $projectQuestion->frm_option = implode(",",$request->checkBox);
        }
        else{
            $projectQuestion->frm_option = '';
        }

        if ( ! $projectQuestion->save())
      {
         App::abort(500, 'Error');
      }
      else{
         return Redirect::to('my-projects/view/'.$projectQuestion->project_id)->with('success', 'Soru eklendi!');
      }
        
    }

    public function deleteProjectQuestion($id)
    {
        $projectQuestion = ProjectQuestion::find($id);

      if ( ! $projectQuestion->delete())
      {
         App::abort(500, 'Error');
      }
      else{
         return Redirect::to('my-projects/view/'.$projectQuestion->project_id)->with('success', 'Soru silindi!');
      }
    }


    public function storeNewProjectProcess(Request $request)
    {
         $projectProcessCount=ProjectCurrentProcess::distinct()->where('project_id',$request->project_id)->count();
         $projectProcess=new ProjectCurrentProcess;
         $projectProcess->project_id=$request->project_id;
         $projectProcess->process="Mevcut Süreç ".$projectProcessCount+1;
         $projectProcess->title=$request->title;
         
         if ( ! $projectProcess->save())
         {
           App::abort(500, 'Error');
         }
        else{
           return Redirect::to('my-projects/view/'.$projectProcess->project_id)->with('success', 'Mevcut süreç eklendi!');
        }
    }


    public function deleteProjectProcess($id)
    {
      $projectProcess=ProjectCurrentProcess::find($id);

      if ( ! $projectProcess->delete())
      {
         App::abort(500, 'Error');
      }
      else{
         return Redirect::to('my-projects/view/'.$projectProcess->project_id)->with('success', 'Mevcut süreç silindi!');
      }
    }

    public function editMyProject(Request $request,$id)
    {
      $project = Project::find($id);
      $project->user_id = $request->userId;

      if(!empty($request->userId)){
         ProjectWorkTeam::updateOrCreate(
            ['project_id' => $project->id, 'user_id' => $project->user_id, 'authorization' => 1]
         );
      }

      if(empty($request->title)){
         $project->title = $project->title;
      }else{
         $project->title = $request->title;
      }
      if(empty($request->description)){
         $project->description = $project->description;
      }else{
         $project->description = $request->description;
      }
      $project->unit_id = $request->unit_id;
      $project->save();


      for($i=0;$i<$request->questionCount;$i++){
         $answer = ProjectAnswer::where('question_id',$request->question_id[$i])->first();
         if(!empty($answer)){
            $answer->project_id=$project->id;
            $answer->question_id=$request->question_id[$i];
            if($request->type[$i]=='textfield_s'){
              $t="text".$request->question_id[$i];
              $answer->answer = ($request->$t == null) ? $answer->answer : $request->$t ;
            }
            elseif($request->type[$i]=='radio_opt'){
              $r="radio".$request->question_id[$i];
              $answer->answer = ($request->$r == null) ? $answer->answer : $request->$r ;
            }
            elseif($request->type[$i]=='check_opt'){
              $c=$request->input('checkBox'.$request->question_id[$i]);
              $answer->answer = ($c == null) ? $answer->answer : $answer->answer=implode(",",$c);
            }
            $answer->save();
         }
         else{
            $answer=new ProjectAnswer;
            $answer->project_id=$project->id;
            $answer->question_id=$request->question_id[$i];
            if($request->type[$i]=='textfield_s'){
              $t="text".$request->question_id[$i];
              $answer->answer=$request->$t;
            }
            elseif($request->type[$i]=='radio_opt'){
              $r="radio".$request->question_id[$i];
              $answer->answer=$request->$r;
            }
            elseif($request->type[$i]=='check_opt'){
              $c=$request->input('checkBox'.$request->question_id[$i]);
              $answer->answer=implode(",",$c);
            }
            $answer->save();
         }
         
       }

      for($i=0;$i<$request->processCount;$i++){
         $process= ProjectCurrentProcess::where('id',$request->process_id[$i])->first();
         $process->process=$request->process[$i];
         $process->title=$process->title;
         $process->save();

         $processAnswer= ProjectCurrentProcessAnswers::where('current_process_id',$process->id)->first();
         if(!empty($processAnswer)){
         $processAnswer->current_process_id=$process->id;
         $pa=$request->input('answer'.$request->process_id[$i]);
         $processArray = array();

         //döngü içinde ki 7 düzeltilecek ve dinamik yapılacak. Süreç aşamaları eklenebilir ve database tablosunda tutulmalı.
         for($j=0;$j<7;$j++){
            if($pa[$j] == null){
               $answer = explode("|",$processAnswer->answer);
               $pa[$j] = $answer[$j];
               array_push($processArray,$pa[$j]);
            }else{
               array_push($processArray,$pa[$j]);
            }
         }
         $processAnswer->answer=implode("|",$pa);
         $processAnswer->save();
       }
       else{
         $processAnswer=new ProjectCurrentProcessAnswers;
         $processAnswer->project_id=$id;
         $processAnswer->current_process_id=$process->id;
         $pa=$request->input('answer'.$request->process_id[$i]);
         $processAnswer->answer=implode("|",$pa);
         $processAnswer->save();
       }
      }
       return Redirect::to('my-projects/view/'.$id)->with('success', 'Proje Güncellendi!');

    }

}
 