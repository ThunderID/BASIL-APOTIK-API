<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class OrgGroupController extends Controller
{
	protected $layout;

	function __construct()
	{
		$this->layout = view('admin.layout.dashboard');
		$this->layout->title = "Clients";
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
		$this->layout->page = view('admin.user.index');

		/*----------  Get OrgType  ----------*/
		$org_groups = \App\OrgGroup::with('owner', 'orgs')->paginate(1);
		$this->layout->page->org_groups = $org_groups;
		
		/*=====  End of Page  ======*/
		

		/*================================
		=            Response            =
		================================*/
		return $this->layout;
		/*=====  End of Response  ======*/
		
	}
}
