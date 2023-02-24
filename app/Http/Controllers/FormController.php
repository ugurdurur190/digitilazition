<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Unit;
use App\Models\Form;
use App\Models\FormCurrentProcess;
use App\Models\FormQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use function PHPSTORM_META\type;

class FormController extends Controller
{

   public function __construct()
   {
       $this->middleware('auth');

   }

   public function newForm()
   {
    return view('forms.form-new');
   }

   
   public function storeForm(Request $request)
   {
      
        $forms=new Form;
        $forms->user_id=Auth::user()->id;
        $forms->title=$request->title;
        $forms->description=$request->description;

        if ( ! $forms->save())
        {
           App::abort(500, 'Error');
        }
        else{
           return Redirect::to('forms/list')->with('success', "'$forms->title' Formu Oluşturuldu!");
        }
   }

   public function listForm()
   {
      $projectForms = Form::all();
      $forms = array();

      foreach($projectForms as $projectForm){
         $questionCount = FormQuestion::where('form_id',$projectForm->id)->count();
         $processCount = FormCurrentProcess::where('form_id',$projectForm->id)->count();
         if(Auth::user()->privilege_id == 1){
            $forms = Form::all();
         }
         elseif($questionCount != 0 || $processCount != 0){
            array_push($forms,Form::where('id',$projectForm->id)->first());
         }
      }

      return view('forms.form-list',['forms'=>$forms]);
   }


   public function deleteForm($id)
   {
      $forms=Form::find($id);

      if ( ! $forms->delete())
      {
         App::abort(500, 'Error');
      }
      else{
         return Redirect::to('forms/list')->with('success', "'$forms->title' Formu Silindi!");
      }
   }

   public function editForm($id)
   {
      $forms=Form::find($id);
      if(isset($forms)){
         return view('forms.form-edit',['forms'=>$forms]);
      }
      else{
         return Redirect::to('forms.forms/list')->with('warning', 'Böyle bir proje formu yok!');
      }
   }

   public function updateForm(Request $request,$id)
   {
      $forms=Form::find($id);
      $forms->user_id=$forms->user_id;
      $forms->title=$request->title;
      $forms->description=$request->description;
      if ( ! $forms->save())
      {
         App::abort(500, 'Error');
      }
      else{
         return Redirect::to('forms/list')->with('success', "'$forms->title' Formu Güncellendi!");
      }
   }

   public function viewForm($id)
   {
      $forms=Form::find($id);
      $questions = FormQuestion::where('form_id',$id)->get();
      $process = FormCurrentProcess::where('form_id',$id)->get();
      $users = User::all();
      $units = Unit::all();
      if(isset($forms)){
         return view('forms.form-view',['forms'=>$forms, "questions" => $questions, "process" => $process, "users" => $users, "units" => $units]);
      }
      else{
         return Redirect::to('forms.forms/list')->with('warning', 'Böyle bir proje formu yok!');
      }
      
   }


   public function viewContinuesProjectForm($id)
   {
      $forms=Form::find($id);
      $questions = FormQuestion::where('form_id',$id)->get();
      $process = FormCurrentProcess::where('form_id',$id)->get();
      $users = User::all();
      $units = Unit::all();
      if(isset($forms)){
         return view('forms.form-continuesProject',['forms'=>$forms, "questions" => $questions, "process" => $process, "users" => $users, "units" => $units]);
      }
      else{
         return Redirect::to('forms.forms/list')->with('warning', 'Böyle bir proje formu yok!');
      }
   }


   public function storeQuestion(Request $request)
   {
      $questions=new FormQuestion;
         
      $questions->form_id=$request->form_id;
      $questions->question=$request->question;
      $questions->type=$request->type;
      if($questions->type=='radio_opt'){
         $questions->frm_option = implode(",",$request->radio);
      }
      elseif($questions->type=='check_opt'){
         $questions->frm_option = implode(",",$request->checkBox);
      }
      else{
         $questions->frm_option = '';
      }

         
      if ( ! $questions->save())
      {
         App::abort(500, 'Error');
      }
      else{
         return Redirect::to('forms/view/'.$questions->form_id)->with('success', 'Soru eklendi!');
      }
   }


   public function deleteQuestion($id)
   {
      $questions=FormQuestion::find($id);

      if ( ! $questions->delete())
      {
         App::abort(500, 'Error');
      }
      else{
         return Redirect::to('forms/view/'.$questions->form_id)->with('success', 'Soru silindi!');
      }
   }


   public function storeProcess(Request $request)
    {
         $processCount=FormCurrentProcess::distinct()->where('form_id',$request->form_id)->count();
         $process=new FormCurrentProcess;
         $process->form_id=$request->form_id;
         $process->process="Mevcut Süreç ".$processCount+1;
         $process->title=$request->title;
         
         if ( ! $process->save())
         {
           App::abort(500, 'Error');
         }
        else{
           return Redirect::to('forms/view/'.$process->form_id)->with('success', 'Mevcut süreç eklendi!');
        }
    }

   public function deleteProcess($id)
   {
      $process=FormCurrentProcess::find($id);

      if ( ! $process->delete())
      {
         App::abort(500, 'Error');
      }
      else{
         return Redirect::to('forms/view/'.$process->form_id)->with('success', 'Mevcut süreç silindi!');
      }
   }



}