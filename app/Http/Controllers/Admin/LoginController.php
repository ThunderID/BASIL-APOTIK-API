<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use LaravelFCM\Message\Topics;

class LoginController extends Controller
{
	protected $layout;

	function __construct()
	{
		$this->layout = view('admin.layout.login');
	}

	public function form(Request $request)
	{
		$notificationBuilder = new PayloadNotificationBuilder('my title');
		$notificationBuilder->setBody('Hello world')
						    ->setSound('default');

		$notification = $notificationBuilder->build();

		$topic = new Topics();
		$topic->topic('restaurant');

		$topicResponse = FCM::sendToTopic($topic, null, $notification, null);

		$topicResponse->isSuccess();
		$topicResponse->shouldRetry();
		$topicResponse->error();
		dd($topicResponse);

		/*============================
		=            Page            =
		============================*/
		$this->layout->page = view('admin.pages.login', $request->old());
		/*=====  End of Page  ======*/
		

		/*================================
		=            Response            =
		================================*/
		return $this->layout;
		/*=====  End of Response  ======*/
		
	}

	public function post_form(Request $request)
	{
		/*=======================================
		=            Process Request            =
		=======================================*/
		if ($request->input('username') && $request->input('password'))
		{
			$user = \App\User::authenticate($request->input('username'), $request->input('password'));
			if ($user)
			{
				Auth::guard('admin')->login($user);
			}
		}
		/*=====  End of Process Request  ======*/
		

		/*================================
		=            Response            =
		================================*/
		if (!isset($user) || !$user)
		{
			return redirect()->route('login')
							 ->withInput(
									$request->except('password')
								)
							 ->with('alert_danger', 'Invalid username and password combination');
		}
		else
		{
			return redirect()->route('dashboard.index');
		}
		/*=====  End of Response  ======*/
		
	}

	public function logout()
	{
		Auth::guard('admin')->logout();
		return redirect()->route('login');
	}
}
