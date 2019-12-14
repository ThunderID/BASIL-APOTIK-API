<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\OrgGroup;
use Validator;

class UserController extends Controller
{
	protected $layout;

	function __construct()
	{
		$this->layout = view('admin.layout.dashboard');
		$this->layout->title = "Users";
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
		$this->layout->page = view('admin.pages.user.index');

		/*----------  Get OrgType  ----------*/
		if ($request->input('mode') == 'owner')
		{
			$users = \App\User::hasOrgGroup()->paginate(25);
		}
		else
		{
			$users = \App\User::paginate(25);
		}

		$this->layout->page->users = $users;

		/*=====  End of Page  ======*/

		/*================================
		=            Response            =
		================================*/
		return $this->layout;
		/*=====  End of Response  ======*/

	}

	public function show(Request $request, Int $id)
	{
		/*============================
		=            Load            =
		============================*/
		$user = User::with('org_groups', 'org_groups.orgs')->findorfail($id);
		/*=====  End of Load  ======*/

		/*==============================
		=            Layout            =
		==============================*/
		$this->layout->title .= " - Detail";
		/*=====  End of Layout  ======*/

		/*============================
		=            Page            =
		============================*/
		$this->layout->page = view('admin.pages.user.show');
		$this->layout->page->user = $user;

		/*=====  End of Page  ======*/


		/*================================
		=            Response            =
		================================*/
		return $this->layout;
		/*=====  End of Response  ======*/
	}

	public function form(Request $request, Int $id = null)
	{
		/*============================
		=            Load            =
		============================*/
		if ($id)
		{
			$user = User::findorfail($id);
		}
		else
		{
			$user = new User;
		}
		/*=====  End of Load  ======*/

		/*==============================
		=            Layout            =
		==============================*/
		$this->layout->title .= " - " . ($id ? 'Edit ' . $user->name : 'Create');
		/*=====  End of Layout  ======*/

		/*============================
		=            Page            =
		============================*/
		$this->layout->page = view('admin.pages.user.form');
		$this->layout->page->prev_input = request()->old() ? request()->old() : $user->toArray();
		if ($user)
		{
			$this->layout->page->user = $user;
		}

		/*=====  End of Page  ======*/


		/*================================
		=            Response            =
		================================*/
		return $this->layout;
		/*=====  End of Response  ======*/
	}

	public function post_form(Request $request, Int $id = null)
	{
		/*================================
		=            Validate            =
		================================*/
		if (!$id)
		{
			$rules['password'][] = 'confirmed';
			$request->validate($rules);
		}

		/*=====  End of Validate  ======*/

		/*===============================
		=            Process            =
		===============================*/
		if ($id)
		{
			$user = User::findorfail($id);
			$user->fill($request->input());
			$user->save();
		}
		else
		{
			$user = User::create($request->input());
		}
		/*=====  End of Process  ======*/


		/*================================
		=            Response            =
		================================*/
		if (!$user)
		{
			return back()->withInput();
		}
		else
		{
			return redirect()->route('user.show', ['id' => $user->id])
							 ->with('alert_success', 'Data has been saved succesfully');;
		}
		/*=====  End of Response  ======*/
	}

	public function form_org_group(Request $request, Int $user_id, Int $id = null)
	{
		/*============================
		=            Load            =
		============================*/
		$user = User::findorfail($user_id);
		if ($id)
		{
			$org_group = $user->org_groups->firstWhere('id', '=', $id);
			if (!$org_group) 
			{
				abort(404);
			}
		}
		else
		{
			$org_group = new OrgGroup;
		}
		/*=====  End of Load  ======*/

		/*==============================
		=            Layout            =
		==============================*/
		$this->layout->title .= " - " . ($id ? 'Edit Org Group: ' . $org_group->name : 'Create Org Group');
		/*=====  End of Layout  ======*/

		/*============================
		=            Page            =
		============================*/
		$this->layout->page = view('admin.pages.user.org_group.form');
		$this->layout->page->prev_input = request()->old() ? request()->old() : $org_group->toArray();
		$this->layout->page->user = $user;
		if (isset($org_group))
		{
			$this->layout->page->org_group = $org_group;
		}

		/*=====  End of Page  ======*/


		/*================================
		=            Response            =
		================================*/
		return $this->layout;
		/*=====  End of Response  ======*/
	}

	public function post_form_org_group(Request $request, Int $user_id, Int $id = null)
	{
		/*============================
		=            Load            =
		============================*/
		$user = User::findorfail($user_id);
		/*=====  End of Load  ======*/
		

		/*================================
		=            Validate            =
		================================*/
		/*=====  End of Validate  ======*/

		/*===============================
		=            Process            =
		===============================*/
		if ($id)
		{
			$org_group = $user->org_groups->firstWhere('id', '=', $id);
			$org_group->fill($request->input());
			$org_group->save();
			if (!$org_group) 
			{
				abort(404);
			}
		}
		else
		{
			$org_group = $user->org_groups()->create($request->input());
		}


		/*=====  End of Process  ======*/


		/*================================
		=            Response            =
		================================*/
		if (!$org_group)
		{
			return back()->withInput();
		}
		else
		{
			return redirect()->route('user.show', ['id' => $user->id, 'mode' => 'org_group', 'org_group_id' => $org_group->id])
							 ->with('alert_success', 'Data has been saved succesfully');
		}
		/*=====  End of Response  ======*/
	}

	public function form_org(Request $request, Int $user_id, Int $id = null)
	{
		/*============================
		=            Load            =
		============================*/
		$user = User::findorfail($user_id);
		if ($id)
		{
			$org = $user->orgs->firstWhere('id', '=', $id);
			if (!$org) 
			{
				abort(404);
			}
		}
		else
		{
			$org = new OrgGroup;
		}
		/*=====  End of Load  ======*/

		/*==============================
		=            Layout            =
		==============================*/
		$this->layout->title .= " - " . ($id ? 'Edit Org Group: ' . $org->name : 'Create Org Group');
		/*=====  End of Layout  ======*/

		/*============================
		=            Page            =
		============================*/
		$this->layout->page = view('admin.pages.user.org.form');
		$this->layout->page->prev_input = request()->old() ? request()->old() : $org->toArray();
		$this->layout->page->user = $user;
		if (isset($org))
		{
			$this->layout->page->org = $org;
		}

		/*=====  End of Page  ======*/


		/*================================
		=            Response            =
		================================*/
		return $this->layout;
		/*=====  End of Response  ======*/
	}

	public function post_form_org(Request $request, Int $user_id, Int $id = null)
	{
		/*============================
		=            Load            =
		============================*/
		$user = User::findorfail($user_id);
		/*=====  End of Load  ======*/
		

		/*================================
		=            Validate            =
		================================*/
		/*=====  End of Validate  ======*/

		/*===============================
		=            Process            =
		===============================*/
		if ($id)
		{
			$org = $user->orgs->firstWhere('id', '=', $id);
			$org->fill($request->input());
			$org->save();
			if (!$org) 
			{
				abort(404);
			}
		}
		else
		{
			$org = $user->orgs()->create($request->input());
		}


		/*=====  End of Process  ======*/


		/*================================
		=            Response            =
		================================*/
		if (!$org)
		{
			return back()->withInput();
		}
		else
		{
			return redirect()->route('user.show', ['user_id' => $user->id, 'mode' => 'org_group', 'org_group_id' => $org->org_group_id])
							 ->with('alert_success', 'Data has been saved succesfully');
							 
		}
		/*=====  End of Response  ======*/
	}
}
