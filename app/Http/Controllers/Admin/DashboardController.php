<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
	protected $layout;

	function __construct()
	{
		$this->layout = view('admin.layout.dashboard');
	}

	public function index(Request $request)
	{
		/*==============================
		=            Layout            =
		==============================*/
		$this->layout->title = "Dashboard";
		/*=====  End of Layout  ======*/
		
		/*============================
		=            Page            =
		============================*/
		$this->layout->page = view('admin.pages.dashboard.index');

		/*----------  Total Client  ----------*/
		$this->layout->page->user_count      = \App\User::has('org_groups')->count();
		$this->layout->page->prev_user_count = \App\User::has('org_groups')
																->where('created_at', '<', now()->startOfMonth())
																->count();

		/*----------  Total OrgGroup  ----------*/
		$this->layout->page->org_group_count = \App\OrgGroup::count();
		$this->layout->page->prev_org_group_count = \App\OrgGroup::where('created_at', '<', now()->startOfMonth())
																->count();

		/*----------  Total Org  ----------*/
		$this->layout->page->org_count     = \App\Org::count();
		$this->layout->page->prev_org_count = \App\Org::where('created_at', ' < ', now()->startOfMonth())
														->count();

		/*----------  Latest Org  ----------*/
		$this->layout->page->latest_orgs = \App\Org::with('org_group', 'org_group.owner')->latest('created_at')->take(10)->get();

		/*=====  End of Page  ======*/
		

		/*================================
		=            Response            =
		================================*/
		return $this->layout;
		/*=====  End of Response  ======*/
		
	}
}
