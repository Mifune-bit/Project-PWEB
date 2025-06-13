<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class ForgotPasswordController extends Controller
{
    // Tampilkan form lupa password
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Proses permintaan reset password
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users']);
        
        $token = Str::random(64);
        
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        
        Mail::to($request->email)->send(new ResetPasswordMail($token));
        
        return back()->with('success', 'Kami telah mengirim link reset password ke email Anda!');
    }

    // Tampilkan form reset password
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Proses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'token' => 'required'
        ]);
        
        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();
            
        if(!$updatePassword) {
            return back()->withInput()->with('error', 'Token tidak valid!');
        }
        
        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);
            
        DB::table('password_resets')->where(['email'=> $request->email])->delete();
        
        return redirect('/login')->with('success', 'Password Anda berhasil diubah!');
    }
}