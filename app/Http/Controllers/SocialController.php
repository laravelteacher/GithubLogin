<?php

 namespace App\Http\Controllers;
 
 use Illuminate\Http\Request;
 use Validator,Redirect,Response,File;
 use Socialite;
 use App\Models\User;
 use Auth;
 
 class SocialController extends Controller
 {
     public function redirect()
     {
         return Socialite::driver('github')->redirect();
     }
        
 
     public function callback()
     {
         try {
      
             $user = Socialite::driver('github')->user();
       
             $findUser = User::where('github_id', $user->id)->first();
       
             if($findUser){
       
                 Auth::login($findUser);
      
                 return redirect('/home');
       
             }else{
                 $user = User::create([
                     'name' => $user->name,
                     'email' => $user->email,
                     'github_id'=> $user->id,
                     'provider'=> 'github',
                     'password' => encrypt('555555555555')
                 ]);
      
                 Auth::login($user);
       
                 return redirect('/home');
                // dd($user->name);
             }  // git_id
      
         } catch (Exception $e) {
             dd($e->getMessage());
         }
     }
 
}