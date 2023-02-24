<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\ProjectPermission;
use App\Models\ProjectAffectedUnit;
use App\Models\ProjectVote;
use App\Models\User;

class NotificationController extends Controller
{

   public function __construct()
   {
       $this->middleware('auth');
   }

   //get unapproved project
   public function getUnapprovedProjects()
   {
    $projects = Project::all();
    $unapproved_projects = array();
    $affected_units = ProjectAffectedUnit::where(['affected_units_id' => Auth::user()->unit_id, 'approval' => 0])->get();
    foreach($affected_units as $affected_unit){
        array_push($unapproved_projects,Project::where('id',$affected_unit->project_id)->first());
    }

    return $unapproved_projects;

   }

   //get unrated projects
   public function getUnratedProjects()
   {
    $permissions = ProjectPermission::where("permission",1)->get('project_id');
    $allowed_projects = array();
    $unrated_projects = array();

    foreach($permissions as $permission){
        array_push($allowed_projects,Project::where('id',$permission->project_id)->first());
    }

    foreach($allowed_projects as $allowed_project){
        $vote = ProjectVote::where(["project_id" => $allowed_project->id, "user_id" => Auth::user()->id])->count();
        if($vote == 0){
            array_push($unrated_projects,$allowed_project);
        }else{
            continue;
        }
    }
    
    return $unrated_projects;
   }


   public function getUnapprovedProjectCount()
   {
    $unapprovedProjectCount = count($this->getUnapprovedProjects());
    return $unapprovedProjectCount;
   }

   public function getUnratedProjectCount()
   {
    $unratedProjectCount = count($this->getUnratedProjects());
    return $unratedProjectCount;
   }

}
 