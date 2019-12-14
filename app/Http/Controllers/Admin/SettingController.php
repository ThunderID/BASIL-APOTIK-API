<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;
use Auth;

class SettingController extends Controller
{
	protected $layout;

	function __construct()
	{
		$this->layout = view('admin.layout.dashboard');
		$this->layout->title = "Setting";
		$this->layout->page = view('admin.pages.settings.index');
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
}
