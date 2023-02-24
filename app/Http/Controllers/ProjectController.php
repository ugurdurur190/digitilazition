<?php
namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Project;
use App\Models\ProjectAffectedUnit;
use App\Models\ProjectAnswer;
use App\Models\ProjectCurrentProcess;
use App\Models\ProjectCurrentProcessAnswers;
use App\Models\ProjectPermission;
use App\Models\ProjectQuestion;
use App\Models\ProjectVote;
use App\Models\ProjectVoteQuestion;
use App\Models\ProjectWorkTeam;
use App\Models\ProjectTodo;
use App\Models\ProjectActivite;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail as FacadesMail;

class ProjectController extends Controller
{

  public function __construct()
   {
       $this->middleware('auth');

   }
   
    public function storeProject(Request $request)
    {
      if($request->questionCount != 0 || $request->processCount !=0){
        //new project
        $project = new Project;
        $project->user_id = $request->userId;
        $project->unit_id = $request->unit_id;
        $project->title = $request->title;
        $project->description = $request->description;
        $project->score = $request->score;
        $project->save();

        //project question store
        for($i=0;$i<$request->questionCount;$i++){
          $question=new ProjectQuestion;
          $question->project_id=$project->id;
          $question->question=$request->question[$i];
          $question->type=$request->type[$i];
          if($question->type=='radio_opt' || $question->type=='check_opt'){
            $question->frm_option = $request->frm_option[$i];
          }
          else{
              $question->frm_option = '';
          }
          $question->save();

          //project answer store
          $answer=new ProjectAnswer;
          $answer->project_id=$project->id;
          $answer->question_id=$question->id;
          if($question->type=='textfield_s'){
            $t="text".$request->question_id[$i];
            $answer->answer=$request->$t;
          }
          elseif($question->type=='radio_opt'){
            $r="radio".$request->question_id[$i];
            $answer->answer=$request->$r;
          }
          elseif($question->type=='check_opt'){
            $c=$request->input('checkBox'.$request->question_id[$i]);
            $answer->answer=implode(",",$c);
          }
          $answer->save();
        }

        //project current process store
        for($i=0;$i<$request->processCount;$i++){
          $process=new ProjectCurrentProcess;
          $process->project_id=$project->id;
          $process->process=$request->process[$i];
          $process->title=$request->process_title[$i];
          $process->save();

          $processAnswer=new ProjectCurrentProcessAnswers;
          $processAnswer->project_id=$project->id;
          $processAnswer->current_process_id=$process->id;
          $pa=$request->input('answer'.$request->process_id[$i]);
          $processAnswer->answer=implode("|",$pa);
          $processAnswer->save();
        }

        for($i=0;$i<count($request->input('unit'));$i++){
          $unit = new ProjectAffectedUnit;
          $unit->project_id = $project->id;
          $u=$request->input('unit')[$i];
          $unit->affected_units_id=$u;
          if(empty($project->score)){
            $unit->approval = 0;
          }else{
            $unit->approval = 1;
          }
            
          
          $unit->save();

          $users = User::where('unit_id',$unit->affected_units_id)->get();
          //project affected unit
          $unitUser = Unit::where('id',$unit->affected_units_id)->value('unit');
          //project unit
          $projectUnit = Unit::where('id',$project->unit_id)->value('unit');
          //project owner
          $projectUser = User::where('id',$project->user_id)->value('name');
          foreach($users as $user){
            FacadesMail::raw("Proje sahibi: '$projectUser' Proje birimi: '$projectUnit' olan '$project->title' projesi'nin, etkilenen birimlerine dahilsiniz '$unitUser' birimi olarak birim onayınızı düzenleyiniz! ",function($message) use ($user){
                $message->to($user->email)->subject('Dijitalleşme Projeleri Etkilenen Birim Onay Uyarısı');
            });
          }
        }

        
        $voteQuestions=array('Dijitaleşme Projesi mi?','Uygulanabilir mi?','Gerekli mi?',
            'Vizyon ve Misyona Uygun mu?','Ciroya Etki','İç/Dış müşteri gerekliliği ve termini',
            'Rekabete Etkisi','İş gücü kesintisi önleyecek seviyede bir gereklilik mi?',
            'Regülasyon gerekliliği ve termini','Zaman','Kaynak','Maliyet','Optimizasyon Seviyesi','Dış kaynak alternatifi var mı? / Yenilikçi yönü');
            foreach($voteQuestions as $voteQuestion){
              $projectVoteQuestions = new ProjectVoteQuestion;
              $projectVoteQuestions->project_id = $project->id;
              $projectVoteQuestions->question = $voteQuestion;
              $projectVoteQuestions->save();
            }

            $permission = new ProjectPermission;
            $permission->project_id = $project->id;
            $permission->permission = 0;
            $permission->save();
            

            $teams = new ProjectWorkTeam;
            $teams->project_id = $project->id;
            $teams->user_id = $project->user_id;
            $teams->authorization = 1;
            $teams->save();

            if(empty($project->score)){
               return Redirect::to('projects/list')->with('success', 'Proje Kaydedildi!');
            }else{
               return Redirect::to('projects/continues/list')->with('success', 'Proje Kaydedildi!');
            }
            
      }
      else{
        return Redirect::to('forms/view/'.$request->formId)->with('warning', 'Admin en az bir soru veya mevcut süreç eklemeli!');
      }

    }


    public function listProject()
    {
      $forms=Form::all();
      $projects = Project::where('score',null)->get();
      $users = User::all();
      $voteDone=ProjectVote::distinct()->where('user_id',Auth::user()->id)->pluck('project_id')->toArray();
      return view('projects.project-list',["users" => $users, "projects" => $projects, "voteDone"=>$voteDone]);
    }

    public function listContiunesProject()
    {
      $users = User::all();
      $votes = ProjectVote::all();
      $voteQuestions = ProjectVoteQuestion::all();
      $projects = Project::all();
      $continuesProjects = array();

      foreach($projects as $project){
         $affectedUnitCount = ProjectAffectedUnit::where('project_id',$project->id)->count();
         $affectedUnitApproval = ProjectAffectedUnit::where(['project_id' => $project->id,'approval' => 1])->count();
         $todoCount = ProjectTodo::where('project_id',$project->id)->count();
         if($todoCount == 0){
            $todoCount = 1;
         }
         $doneTodoCount = ProjectTodo::where(['project_id' => $project->id, 'board_id' => 3])->count();

         if($affectedUnitCount == $affectedUnitApproval && $todoCount != $doneTodoCount){
            array_push($continuesProjects,Project::where('id',$project->id)->first());
         }
      }

      return view('projects.continues-project-list',["users" => $users, "continuesProjects" => $continuesProjects, "votes" => $votes, "voteQuestions" => $voteQuestions]);
    }


    public function listCompletedProject()
    {
      $users = User::all();
      $votes = ProjectVote::all();
      $voteQuestions = ProjectVoteQuestion::all();
      $projects = Project::all();
      $completedProjects = array();
      $projectActivites = ProjectActivite::all();

      foreach($projects as $project){
         $todoCount = ProjectTodo::where('project_id',$project->id)->count();
         $doneTodoCount = ProjectTodo::where(['project_id' => $project->id, 'board_id' => 3])->count();
         if($todoCount != 0 && $todoCount == $doneTodoCount){
            array_push($completedProjects,Project::where('id',$project->id)->first());
         }
      }
      
      return view('projects.completed-project-list',["users" => $users, "completedProjects" => $completedProjects, "projectActivites" => $projectActivites, "votes" => $votes, "voteQuestions" => $voteQuestions]);
    }

    
    public function viewProject($id)
    {
      $projects = Project::all()->find($id);
      $questions = ProjectQuestion::where('project_id',$id)->get();
      $answers = ProjectAnswer::where("project_id",$id)->get();
      $processes = ProjectCurrentProcess::where("project_id",$id)->get();
      $processAnswers = ProjectCurrentProcessAnswers::where("project_id",$id)->get();
      $affectedUnits = ProjectAffectedUnit::where("project_id",$id)->get();
      $users = User::all();
      $units = Unit::all();

      if(isset($projects)){
         return view('projects.project-view',["questions" => $questions, "answers" => $answers, "processes" => $processes, "processAnswers" => $processAnswers, "users" => $users, "projects" => $projects, "units" => $units, "affectedUnits" => $affectedUnits]);
      }
      else{
         return Redirect::to('projects/list')->with('warning', 'Böyle bir proje yok!');
      }
    }

   public function deleteProject($id)
   {
      $projects = Project::find($id);

      if ( ! $projects->delete())
      {
         App::abort(500, 'Error');
      }
      else{
         if(empty($projects->score)){
            return Redirect::to('projects/list')->with('success', 'Proje silindi!');
         }else{
            return Redirect::to('projects/continues/list')->with('success', 'Proje silindi!');
         }
      }
   }


   public function unitApproval($id)
   {
      $projects = Project::all()->find($id);
      //
      $projectPermission = ProjectPermission::where('project_id',$id)->value('permission');
      $affectedUnits=ProjectaffectedUnit::where('project_id',$id)->get();
      $units = Unit::all();
      $users = User::all();

      if(isset($projects)){
         if($projectPermission == 0){
            return view('projects.project-unitApproval',["projects" => $projects, "affectedUnits" => $affectedUnits, "units" => $units, "users" => $users]);
         }
         else{
            return Redirect::to('projects/list')->with('warning', 'Proje Oylamaya Açık. Birim Onayları Değiştirilemez!');
         }
      }
      else{
         return Redirect::to('projects/list')->with('warning', 'Böyle bir proje yok!');
      }
   }



   public function storeUnitApproval(Request $request,$id)
   {
      $unitApproval=ProjectAffectedUnit::find($id);
      $approval="approval$unitApproval->affected_units_id";
      $unitApproval->approval = $request->$approval;

      //Affected Unit user count
      $unitUserCount = User::where('unit_id',$unitApproval->affected_units_id)->count();
      //Affected Unit name (mail send)
      $affectedUnitName = Unit::where('id',$unitApproval->affected_units_id)->value('unit');
      //Project Affected Unit name
      $projectUnit = Unit::where('id',Project::where('id',$request->project_id)->value('unit_id'))->value('unit');

      if ( ! $unitApproval->save())
      {
         App::abort(500, 'Error');
      }
      else{
        //Project Owner
        $projectOwner=User::where('id',Project::where('id',$request->project_id)->value('user_id'))->value('name');
        $projectTitle=Project::where('id',$request->project_id)->value('title');

        //Project Affected Unit count
        $affectedUnitCount = ProjectAffectedUnit::where('project_id',$request->project_id)->count();
        //Project Approval(approval=1) Affected Unit count
        $approvalUnitCount = ProjectAffectedUnit::where(['project_id'=>$request->project_id,'approval'=>1])->count();
        $allUsers = User::all();
        
         if($unitUserCount > 1){
            $users = User::where('unit_id',$unitApproval->affected_units_id)->get();
            foreach($users as $user){
               FacadesMail::raw("Proje sahibi: $projectOwner , Proje birimi: $projectUnit , Olan $projectTitle projesi'nin , $affectedUnitName birim onayı , $user->email tarafından Düzenlenmiştir! ",function($message) use ($user){
                  $message->to($user->email)->subject('Dijitalleşme Projeleri Etkilenen Birim Onay Uyarısı');
               });
            }
         }

         if($affectedUnitCount == $approvalUnitCount){

            $projectPermission = ProjectPermission::where('project_id',$request->project_id)->first();
            $projectPermission->permission = 1;
            $projectPermission->save();

            foreach($allUsers as $allUser){
               FacadesMail::raw("Proje sahibi: $projectOwner , Proje birimi: $projectUnit , Olan $projectTitle projesi'nin tüm etkilenen birim onayları onaylanmış olup proje oylamaya açılmıştır!",function($message) use ($allUser){
                  $message->to($allUser->email)->subject('Dijitalleşme Projeleri Oylamaya Açık Uyarısı');
               });
            }
            return Redirect::to('projects/list')->with('success', "Birim Onayı Kaydedildi.Tüm Birimler Onaylı Olduğundan Proje Oylamaya Açık!");
         }

         return Redirect::to('projects/units/approval/'.$unitApproval->project_id)->with('success', "Birim Onayı Kaydedildi!");
      }
   }


   public function manageVoteQuestions($id)
   {
      $projects = Project::all()->find($id);
      
      $project_permission=ProjectPermission::where('project_id',$id)->value('permission');
      $affectedUnits=ProjectAffectedUnit::where('project_id',$id)->get();
      $units = Unit::all();
      $users = User::all();
      $projectVoteQuestions = ProjectVoteQuestion::where('project_id',$id)->get();
      $softDelVoteQuestions = ProjectVoteQuestion::where('project_id',$id)->onlyTrashed()->get();

      if(isset($projects)){
         if($project_permission==1){
            return Redirect::to('projects/list')->with('warning', 'Proje Oylamaya Açık. Düzenleme Yapılamaz!');
         }
         else{
            return view('projects.project-voteQuestionManage',["projects" => $projects, "affectedUnits" => $affectedUnits, "units" => $units, "users" => $users, "projectVoteQuestions"=>$projectVoteQuestions, "softDelVoteQuestions"=>$softDelVoteQuestions]);
         }
      }
      else{
         return Redirect::to('projects/list')->with('warning', 'Böyle bir proje yok!');
      }
   }



   public function softDeleteVoteQuestion(Request $request,$id)
   {
      $voteQuestionCount=ProjectVoteQuestion::where('project_id',$request->project_id)->count();
      if($voteQuestionCount > 1){
         $voteQuestion=ProjectVoteQuestion::find($id);
   
         if ( ! $voteQuestion->delete())
         {
            App::abort(500, 'Error');
         }
         else{
            return Redirect::to('projects/votes/questions/manage/'.$request->project_id)->with('success', 'Soru Kaldırıldı!');
         }
      }
      else{
         return Redirect::to('projects/votes/questions/manage/'.$request->project_id)->with('warning', 'Proje değerlendirme anketinde en az bir soru olmalı!');
      }
   }


   public function softRestoreVoteQuestion(Request $request,$id)
   {
      if ( ! ProjectVoteQuestion::withTrashed()->where('id', $id)->restore())
      {
        App::abort(500, 'Error');
      }
      else{
        return Redirect::to('projects/votes/questions/manage/'.$request->project_id)->with('success', 'Soru Geri Yüklendi!');
      }
   }


   public function storeVoteQuestion(Request $request)
   {
        $voteQuestion=new ProjectVoteQuestion;
        $voteQuestion->project_id=$request->project_id;
        $voteQuestion->question=$request->voteQuestion;

        if ( ! $voteQuestion->save())
        {
           App::abort(500, 'Error');
        }
        else{
           return Redirect::to('projects/votes/questions/manage/'.$request->project_id)->with('success', 'Soru Eklendi!');
        }
   }


   public function allowPermissionProject(Request $request,$id)
   {
      $affectedUnitCount=ProjectAffectedUnit::where('project_id',$id)->count();
      $approvalUnitCount=ProjectAffectedUnit::where(['project_id'=>$id, 'approval'=>1])->count();
      if($affectedUnitCount == $approvalUnitCount){
         $permission = ProjectPermission::where('project_id',$id)->first();
         $permission->permission = 1;
      
         if ( ! $permission->save())
         {
            App::abort(500, 'Error');
         }
         else{
            return Redirect::to('projects/list')->with('success', "'$request->project' Projesi Oylamaya Açıldı!");
         }
      }
      else{
         return Redirect::to('projects/votes/questions/manage/'.$id)->with('warning', 'Onaylanmamış Birim Onayı Var!');
      }
   }



   public function voteProject($id)
   {
      $projects = Project::all()->find($id);
      $projectVoteQuestions = ProjectVoteQuestion::where('project_id',$id)->get();
      $projectDone=ProjectVote::where(['project_id' => $id, 'user_id' => Auth::user()->id])->count();
      $projectPermission=ProjectPermission::where('project_id',$id)->value('permission');
      $affectedUnits=ProjectAffectedUnit::where('project_id',$id)->get();
      $votes = ProjectVote::where(['project_id' => $id, 'user_id' => Auth::user()->id])->get();
      $units = Unit::all();
      $users = User::all();
      
      if(isset($projects)){
         if($projectPermission==0){
            return Redirect::to('projects/list')->with('warning', 'Proje Henüz Oylamaya Açılmadı!');
         }
         else{
            return view('projects.project-vote',["projects" => $projects, "projectDone" => $projectDone, "affectedUnits" => $affectedUnits, "votes" => $votes, "units" => $units, "projectVoteQuestions"=>$projectVoteQuestions, "users" => $users]);
         }
      }
      else{
         return Redirect::to('projects/list')->with('warning', 'Böyle bir proje yok!');
      }
   }


   public function storeVote(Request $request,$id)
   {
      $projectVoteQuestions = ProjectVoteQuestion::where("project_id",$id)->count();
      for($i=0;$i<$projectVoteQuestions;$i++){
         $votes=new ProjectVote;
         $votes->project_id=$id;
         $votes->user_id=Auth::user()->id;
         $votes->user_email=Auth::user()->email;
         $votes->privilege_id=Auth::user()->privilege_id;
         $votes->question_id=$request->questionId[$i];
      
         $v="vote$i";
         $votes->vote=$request->$v;
            
         $votes->save();
      }
         return Redirect::to('projects/list')->with('success', 'Oylar Gönderildi!');
   }


   public function updateVote(Request $request,$id)
   {
      $projectVoteQuestions = ProjectVoteQuestion::where("project_id",$id)->count();
      for($i=0;$i<$projectVoteQuestions;$i++){
         $votes=ProjectVote::where(['project_id' => $id, 'user_id' => Auth::user()->id,'question_id' => $request->questionId[$i]])->first();
         $votes->project_id=$id;
         $votes->user_id=Auth::user()->id;
         $votes->user_email=Auth::user()->email;
         $votes->privilege_id=Auth::user()->privilege_id;
         $votes->question_id=$request->questionId[$i];
      
         $v="vote$i";
         $votes->vote=$request->$v;
            
         $votes->save();
      }
         return Redirect::to('projects/list')->with('success', 'Oylar Güncellendi!');
   }


   public function listVoteReport()
   {
      $projects = Project::all();
      $projectPermissions = ProjectPermission::all();
      $users = User::all();
      return view('projects.project-voteReport',["users" => $users, "projects" => $projects, "projectPermissions" => $projectPermissions]);
   }

   

   public function viewVoteReport($id)
   {
      $votes=ProjectVote::where('project_id',$id)->get();
      $questionCount=ProjectVoteQuestion::where('project_id',$id)->count();
      $questionId=ProjectVote::distinct()->where('project_id',$id)->get('question_id')->toArray();
      if($questionId != null){
         for($i=0;$i<$questionCount;$i++){
            $voteExecutiveCount[$i]=ProjectVote::where(['project_id' => $id, 'question_id' => $questionId[$i]])->where('privilege_id','3')->count();
            $voteNormalCount[$i]=ProjectVote::where(['project_id' => $id, 'question_id' => $questionId[$i]])->where('privilege_id','<>','3')->count();
            for($j=0;$j<=5;$j++){
               $questionsExecutiveVoteCount[$i][$j]=(ProjectVote::where(['project_id' => $id, 'question_id' =>$questionId[$i],'vote' => $j])->where('privilege_id','3')->count());          
               $questionsNormalVoteCount[$i][$j]=(ProjectVote::where(['project_id' => $id, 'question_id' => $questionId[$i],'vote' => $j])->where('privilege_id','<>','3')->count());
               $voteRate[$i][$j]=((($questionsExecutiveVoteCount[$i][$j]*10)+($questionsNormalVoteCount[$i][$j]))/(($voteExecutiveCount[$i]*10)+$voteNormalCount[$i]))*100;
               $voteRate[$i][$j]=round($voteRate[$i][$j],0);
            }
         }
         
         
         $projects = Project::all()->find($id);
         $voteQuestions = ProjectVoteQuestion::where("project_id",$id)->get();
         $affectedUnits=ProjectAffectedUnit::where('project_id',$id)->get();
         $questions = ProjectQuestion::where("project_id",$id)->get();
         $answers = ProjectAnswer::where("project_id",$id)->get();
         $users = User::all();
         $units=Unit::all();
   
         return view('projects.project-voteReportView',["questions" => $questions, "answers" => $answers, "users" => $users, "projects" => $projects, "votes" => $votes, "questionCount" => $questionCount, "voteRate" => $voteRate, "units" => $units, "affectedUnits" => $affectedUnits, "voteQuestions" => $voteQuestions ]);
      }

      else{
         return Redirect::to('projects/votes/reports/list')->with('warning', 'Böyle bir proje oylaması yok!');
      }
      
      
   }

}