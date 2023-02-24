<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class CustomAuthController extends Controller
{
    public function index()
    {
    return view('auth.login');
    }

    public function customLogin(Request $request)
    {
       $validator =  $request->validate([
            'email' => 'required',
            'password' => 'required',
            'g-recaptcha-response' => ['required', new ReCaptcha]
        ]);
   
    
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('home')
                        ->withSuccess('Giriş Yapıldı');
        }
        $validator['emailPassword'] = 'E-posta adresi veya şifre yanlış.';
        return redirect("login")->withErrors($validator);
    }

    public function registration()
    {
        return view('auth.registration');
    }
      

    public function customRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("home")->withSuccess('Oturum açtınız');
    }


    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'privelege_id' => 2
      ]);
    }    
    

    public function home()
    {
        if(Auth::check()){
            return view('home-page');
        }
  
        return redirect("login")->withSuccess('Erişmenize izin verilmiyor');
    }
    

    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }


    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
{
    try {
        $user = Socialite::driver('google')->user();
    } catch (\Exception $e) {
        return redirect('login');
    }

    // check if they're an existing user
    $existingUser = User::where('email', $user->email)->first();
    if($existingUser){
        // log them in
        auth()->login($existingUser, true);
    } else {
        // create a new user
        // $newUser                  = new User;
        // $newUser->name            = $user->name;
        // $newUser->email           = $user->email;
        // $newUser->google_id       = $user->id;
        // $newUser->avatar          = $user->avatar;
        // $newUser->avatar_original = $user->avatar_original;
        // $newUser->save();
        // auth()->login($newUser, true);
    }
    return redirect('home');
}
}
 