<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Auth;

class ForgetPasswordController extends Controller
{
	protected $layout;

	function __construct()
	{
		$this->layout = view('admin.layout.login');
	}

	public function form(Request $request)
	{
		/*============================
		=            Page            =
		============================*/
		$this->layout->page = view('admin.pages.forget_password');
		/*=====  End of Page  ======*/
		

		/*================================
		=            Response            =
		================================*/
		return $this->layout;
		/*=====  End of Response  ======*/
		
	}

	public function post_form(Request $request)
	{
		/*================================
		=            Validate            =
		================================*/
		$request->validate(['username' => 'required']);
		
		
		/*=====  End of Validate  ======*/
		
		/*=======================================
		=            Process Request            =
		=======================================*/
		$user = \App\User::username($request->input('username'))->firstOrFail();
		$user->createResetPasswordToken();
		/*=====  End of Process Request  ======*/
		

		/*================================
		=            Response            =
		================================*/
		return redirect()->route('reset_password', ['username' => $request->input('username')]);
		/*=====  End of Response  ======*/
		
	}

	public function reset_form(Request $request)
	{
		/*============================
		=            Page            =
		============================*/
		$this->layout->page = view('admin.pages.reset_password');
		/*=====  End of Page  ======*/
		

		/*================================
		=            Response            =
		================================*/
		return $this->layout;
		/*=====  End of Response  ======*/
		
	}

	public function post_reset_form(Request $request)
	{
		/*================================
		=            Validate            =
		================================*/
		$request->validate([
			'username' => ['required'], 
			'password' => ['required', 'confirmed'], 
			'otp'      => ['required']
		]);
		/*=====  End of Validate  ======*/
		
		/*=======================================
		=            Process Request            =
		=======================================*/
		$user = \App\User::username($request->input('username'))->firstOrFail();
		$resetted = $user->resetPasswordWithToken($request->input('otp'), $request->input('password'));
		/*=====  End of Process Request  ======*/
		

		/*================================
		=            Response            =
		================================*/
		if ($resetted)
		{
			return redirect()->route('login')->with('alert_success', 'Your password has been updated succesfully!');
		}
		else
		{
			throw ValidationException::withMessages(['otp' => 'invalid']);
		}
		/*=====  End of Response  ======*/
		
	}
}
