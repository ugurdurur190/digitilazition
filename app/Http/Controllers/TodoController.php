<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectActivite;
use App\Models\ProjectAffectedUnit;
use App\Models\ProjectCommit;
use App\Models\ProjectPermission;
use App\Models\ProjectTodo;
use App\Models\ProjectWorkTeam;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;
use App\Models\User; //test
use Illuminate\Http\Request;

class todoController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth');

   }


   public function viewWork($id)
   {
      $projects = Project::where('id',$id)->first();
      $todoes = ProjectTodo::where('project_id',$id)->get();
      $commits=ProjectCommit::where('project_id',$id)->get();
      $activites=ProjectActivite::where('project_id',$id)->get();
      $teams=ProjectWorkTeam::where('project_id',$id)->get('user_id');
      $users=User::all();
      $todoCount = ProjectTodo::where('project_id',$id)->count();
      $doneCount = ProjectTodo::where(['project_id' => $id, 'board_id' => 3])->count();
      if($todoCount>0){
         $ratio = 100/$todoCount;
         $completionRate = round($ratio*$doneCount,0);
      }
      else{
         $completionRate = 0;
      }

      $teamCtrl= ProjectWorkTeam::where(['project_id'=>$id, 'user_id'=>Auth::user()->id])->count();
      if($teamCtrl != 0 || Auth::user()->privilege_id == 1){
         return view('projects.project-test',['todoes'=>$todoes, 'projects'=>$projects, 'commits'=>$commits, 'activites'=>$activites, 'completionRate'=>$completionRate, 'users'=>$users , 'teams'=>$teams, 'doneCount'=>$doneCount]);
      }
      else{
         return Redirect::back()->with('warning', 'Bu Projeye Dahil Değilsiniz. Çalışma Alanına Giremezsiniz!');
      }
   }


   public function newTodo($id)
   {
      $users=User::all();
      $projects = Project::where('id',$id)->first();
      $teams = ProjectWorkTeam::where('project_id',$id)->get();
      return view('projects.project-newTest',['users'=>$users, 'projects'=>$projects, 'teams'=>$teams]);
   }


   public function storeTodo(Request $request,$id)
   {
        $todo=new ProjectTodo;
        $todo->project_id=$id;
        $todo->user_id=Auth::user()->id;
        $todo->title=$request->title;
        $todo->description=$request->description;
        $todo->board_id=$request->board_id;
        $todo->save();
        
         return Redirect::to('projects/todoes/works/view/'.$todo->project_id)->with('success', 'Görev Eklendi!');
   }


   public function updateTodo(Request $request,$id)
    {
         $activites=new ProjectActivite;
         $activites->project_id=$id;
         $activites->user_id=Auth::user()->id;
         $activites->todo_id=$request->id;
         $activites->board_id=$request->board_id;
         $activites->save();

         $todos=ProjectTodo::find($request->id);
         $todos->board_id=$request->board_id;
         
         if ( ! $todos->save())
         {
           App::abort(500, 'Error');
         }
        else{
           return Redirect::to('projects/todoes/works/view/'.$activites->project_id);
        }
    }


   public function storeCommit(Request $request,$id)
   {
      $commit = new ProjectCommit;
      $commit->project_id=$id;
      $commit-> user_id=Auth::user()->id;
      $commit->todo_id=$request->todo_id;
      $commit->commit=$request->commit;
      $commit->save();
      
      if (!$commit->save())
      {
         App::abort(500, 'Error');
      }
      else{
         return Redirect::to('projects/todoes/works/view/'.$commit->project_id);
      }
   }

    public function viewTeam($id)
   {
      $projects = Project::where('id',$id)->first();
      $affectedUnits = ProjectAffectedUnit::where("project_id",$id)->get();
      $units = Unit::all();
      $users = User::all();
      $teams = ProjectWorkTeam::where('project_id',$id)->get();

      $teamCtrl= ProjectWorkTeam::where(['project_id'=>$id, 'user_id'=>Auth::user()->id])->count();
      if($teamCtrl != 0 || Auth::user()->privilege_id == 1){
         return view('projects.project-workTeam',["projects"=>$projects, "affectedUnits"=>$affectedUnits, "units"=>$units, "users"=>$users, "teams"=>$teams]);
      }
      else{
         return Redirect::back()->with('warning', 'Bu Projeye Dahil Değilsiniz. Takım Alanına Giremezsiniz!');
      }
   }

   public function storeUserToTeam(Request $request,$id)
   {
        $teams=new ProjectWorkTeam;
        $teams->project_id = $id;
        $teams->user_id = $request->user_id;

        $userCtrl=ProjectWorkTeam::where(['project_id'=>$id, 'user_id'=>$request->user_id])->first();

        if(!isset($userCtrl)){
            if ( ! $teams->save())
            {
               App::abort(500, 'Error');
            }
            else{
               return Redirect::to('projects/todoes/teams/view/'.$teams->project_id)->with('success', 'Kullanıcı Takıma Eklendi!');
            }
        }
        else{
         return Redirect::to('projects/todoes/teams/view/'.$teams->project_id)->with('warning', 'Bu Kullanıcı Zaten Takımda!');
        }
       
   }


   public function deleteUserTeam(Request $request,$id)
   {

      $teams=ProjectWorkTeam::where(['project_id'=>$id, 'user_id'=>$request->user_id])->first();
      $authorization=ProjectWorkTeam::where(['project_id'=>$id, 'user_id'=>$request->user_id])->value('authorization');
      if($authorization != 1){
         if ( ! $teams->delete())
         {
            App::abort(500, 'Error');
         }
         else{
            return Redirect::to('projects/todoes/teams/view/'.$teams->project_id)->with('success', 'Kullanıcı Takımdan Çıkarıldı!');
         }
      }
      else{
         return Redirect::to('projects/todoes/teams/view/'.$teams->project_id)->with('warning', 'Proje Yetkilisi Takımdan Çıkarılamaz!');
      }
      
   }


   public function authorizeUser(Request $request,$id)
   {
      $authorization=ProjectWorkTeam::where(['project_id'=>$id, 'user_id'=>$request->user_id])->value('authorization');
      if($authorization == 0){
         $teams=ProjectWorkTeam::find($request->id);
         $teams->authorization = 1;
         
         if ( ! $teams->save())
         {
            App::abort(500, 'Error');
         }
         else{
            return Redirect::to('projects/todoes/teams/view/'.$id)->with('success', "Kullanıcı Yetkili Yapıldı!");
         }
      }
      else{
         return Redirect::to('projects/todoes/teams/view/'.$id)->with('warning', "Kullanıcı Zaten Yetkili!");
      }
   }

   public function restrictUser(Request $request,$id)
   {
      $authorizedUserCount=ProjectWorkTeam::where(['project_id'=>$id, 'authorization'=>1])->count();
      if($authorizedUserCount > 1){
         $work_teams=ProjectWorkTeam::find($request->id);
         $work_teams->authorization = 0;
         
         if ( ! $work_teams->save())
         {
            App::abort(500, 'Error');
         }
         else{
            return Redirect::to('projects/todoes/teams/view/'.$request->project_id)->with('success', "Kullanıcı Yetkisi Geri Alındı!");
         }
      }
      else{
         return Redirect::to('projects/todoes/teams/view/'.$request->project_id)->with('warning', "En az bir kullanıcı yetkili olmalı!");
      }
      
   }

}