<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;
use Auth;

class MeController extends Controller
{
	protected $layout;

	function __construct()
	{
		$this->layout = view('admin.layout.dashboard');
		$this->layout->title = "My Account";
		$this->layout->page = view('admin.pages.me.index');
	}

	public function index(Request $request)
	{
		/*==============================
		=            Layout            =
		==============================*/
		/*=====  End of Layout  ======*/
		
		/*============================
		=            Page            =
		============================*/
		$this->layout->page->me = Auth::guard('web')->user();
		/*=====  End of Page  ======*/

		/*================================
		=            Response            =
		================================*/
		return $this->layout;
		/*=====  End of Response  ======*/
	}

	public function post_update_password(Request $request)
	{
		/*================================
		=            Validate            =
		================================*/
		$request->validate(['new_password'	=> 'confirmed']);
		/*=====  End of Validate  ======*/

		/*===============================
		=            Process            =
		===============================*/
		$user = Auth::guard('admin')->user();
		if ($user->checkPassword($request->input('current_password')))
		{
			$user->password = $request->input('new_password');
			try {
				$user->save();
			} catch (ValidationException $e) {
				$errors = $e->errors();
				if (isset($errors['password'])) $errors['new_password'] = $errors['password'];
				throw ValidationException::withMessages($errors);
			}
		}
		else
		{
			return back()->with('alert_danger', 'Fail to update your password. Your current password is invalid');
		}
		/*=====  End of Process  ======*/

		/*================================
		=            Response            =
		================================*/
		return redirect()->route('me.index', ['mode' => 'update_password'])->with('alert_success', 'Your password has been updated succesfully');
		
		
		/*=====  End of Response  ======*/
		
	}

	public function post_update_profile(Request $request)
	{
		/*================================
		=            Validate            =
		================================*/
		/*=====  End of Validate  ======*/

		/*===============================
		=            Process            =
		===============================*/
		$user = Auth::guard('admin')->user();
		$user->fill($request->except('password'));
		$user->save();
		/*=====  End of Process  ======*/

		/*================================
		=            Response            =
		================================*/
		return redirect()->route('me.index', ['mode' => 'update_profile'])->with('alert_success', 'Your profile has been updated succesfully');
		
		
		/*=====  End of Response  ======*/
		
	}
}
