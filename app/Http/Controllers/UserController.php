<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

   public function __construct()
   {
       $this->middleware('auth');

   }

   public function newUser()
   {
      $units=Unit::all();
      return view('users.user-new',['units'=>$units]);
   }
   
    public function storeUser(Request $request)
    {
         $this->validate($request,[
            'name' => 'required',
            'privilege_id' => 'required',
            'email' => 'required|email|unique:users',
            'password' => [
               'required',
               'confirmed',
               Password::min(8)
               ->mixedCase()
               ->letters()
               ->numbers()
               ->symbols(),
             ],
             'password_confirmation' => [
               'required',
               Password::min(8)
                   ->mixedCase()
                   ->letters()
                   ->numbers()
                   ->symbols(),
            ],
         ]);
         $users=new User;
 
         $users->name=$request->name;
         $users->email=$request->email;
         $users->privilege_id=$request->privilege_id;
         $users->unit_id=$request->unit_id;
         $users->password=Hash::make($request->password);

         if ( ! $users->save())
         {
          App::abort(500, 'Error');
         }
       else{
          return Redirect::to('users/list')->with('success', "Kullanıcı Kaydedildi!");
         }

    }
 
    public function listUser()
    {
       $users=User::all();
       $units=Unit::all();
       return view('users.user-list',['users'=>$users, 'units'=>$units]);
    }
 
    public function deleteUser($id)
    {
       $users=User::find($id);

       if ( ! $users->delete())
       {
          App::abort(500, 'Error');
       }
       else{
          return Redirect::to('users/list')->with('success', 'Kullanıcı Silindi!');
       }
      
    }
 
    public function editUser($id)
    {
      $units=Unit::all();
      $users=User::find($id);
      if(isset($users)){
         return view('users.user-edit',['users'=>$users, "units"=>$units]);
      }
      else{
         return Redirect::to('users/list')->with('warning', 'Böyle Bir Kullancı Yok!');
      }
       
    }
 
    public function updateUser(Request $request,$id)
    {
       $this->validate($request,[
          'name' => 'required',
          'privilege_id' => 'required',
          'email' => 'required|email|unique:users,email,'.$id.',id',
          'password' => [
            'required',
            'confirmed',
            Password::min(8)
            ->mixedCase()
            ->letters()
            ->numbers()
            ->symbols(),
          ],
          'password_confirmation' => [
            'required',
            Password::min(8)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols(),
         ],
       ]);
       $users=User::find($id);
       $users->name=$request->name;
       $users->privilege_id=$request->privilege_id;
       $users->unit_id=$request->unit_id;
       $users->email=$request->email;
       $users->password=Hash::make($request->password);
       
       if ( ! $users->save())
      {
         App::abort(500, 'Error');
      }
      else{
         return Redirect::to('users/list')->with('success', "Kullanıcı Güncellendi!");
      }
       
    }


    public function viewUserOperation($id)
    {
      if($id == Auth::user()->id){
         $users=User::find($id);
         if(isset($users)){
            return view('users.user-operations',['users'=>$users]);
         }
         else{
            return Redirect::to('/')->with('warning', 'Böyle Bir Kullanıcı Yok!');
         }
      }
      else{
         return Redirect::to('/')->with('warning', 'Hata!');
      }
       
    }



    public function updateUserOperation(Request $request,$id)
    {
      if($id == Auth::user()->id){
         $this->validate($request,[
            'name' => 'required',
            'privilege_id' => 'required',
            'email' => 'required|email|unique:users,email,'.$id.',id',
            'password' => [
               'required',
               'confirmed',
               Password::min(8)
               ->mixedCase()
               ->letters()
               ->numbers()
               ->symbols(),
            ],
            'password_confirmation' => [
               'required',
               Password::min(8)
                  ->mixedCase()
                  ->letters()
                  ->numbers()
                  ->symbols(),
            ],
         ]);
         $userOperations=User::find($id);
         $userOperations->name=$request->name;
         $userOperations->privilege_id=$request->privilege_id;
         $userOperations->email=$request->email;
         $userOperations->password=Hash::make($request->password);
         
         if ( ! $userOperations->save())
         {
            App::abort(500, 'Error');
         }
         else{
            return Redirect::to('/')->with('success', 'Kullanıcı Güncellendi!');
         }
      }
      else{
         return Redirect::to('/')->with('warning', 'Hata!');
      }
       
    }


    public function storeUnit(Request $request)
    {
         $unit = new Unit;
         $unit->unit = $request->unit;

         if ( ! $unit->save())
         {
          App::abort(500, 'Error');
         }
       else{
          return Redirect::to('users/list')->with('success', "Birim Kaydedildi!");
         }

    }

    
}
 