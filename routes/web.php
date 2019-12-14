<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Admin'], function() {
	
	Route::get('/', 											['uses' => 'LoginController@form', 						'as' => 'login']);
	Route::post('/login', 										['uses' => 'LoginController@post_form', 				'as' => 'login.post']);
	Route::get('/logout', 										['uses' => 'LoginController@logout', 					'as' => 'logout']);
	
	Route::get('/forget-password', 								['uses' => 'ForgetPasswordController@form', 					'as' => 'forget_password']);
	Route::post('/forget-password', 							['uses' => 'ForgetPasswordController@post_form', 				'as' => 'forget_password.post']);

	Route::get('/reset-password', 								['uses' => 'ForgetPasswordController@reset_form', 				'as' => 'reset_password']);
	Route::post('/reset-password',	 							['uses' => 'ForgetPasswordController@post_reset_form', 			'as' => 'reset_password.post']);

	Route::group(['middleware' => 'admin', 'prefix' => 'dashboard'], function() {
		Route::get('/', 										['uses' => 'DashboardController@index', 			'as' => 'dashboard.index']);
		
		Route::get('/users', 									['uses' => 'UserController@index', 					'as' => 'user.index']);
		Route::get('/users/form/{id?}', 						['uses' => 'UserController@form', 					'as' => 'user.form']);
		Route::post('/users/form/{id?}',						['uses' => 'UserController@post_form', 				'as' => 'user.form.post']);
		Route::get('/users/{id}',								['uses' => 'UserController@show', 					'as' => 'user.show']);
		
		Route::get('/users/{user_id}/org_group/form/{id?}',		['uses' => 'UserController@form_org_group', 		'as' => 'user.org_group.form']);
		Route::post('/users/{user_id}/org_group/form/{id?}',	['uses' => 'UserController@post_form_org_group', 	'as' => 'user.org_group.form.post']);

		Route::get('/users/{user_id}/org/form/{id?}',			['uses' => 'UserController@form_org', 				'as' => 'user.org.form']);
		Route::post('/users/{user_id}/org/form/{id?}',			['uses' => 'UserController@post_form_org', 			'as' => 'user.org.form.post']);
		
		Route::get('/org_groups',								['uses' => 'OrgGroupController@index', 				'as' => 'org_group.index']);
		
		Route::get('/me',										['uses' => 'MeController@index', 					'as' => 'me.index']);
		Route::post('/me/update-password',						['uses' => 'MeController@post_update_password',		'as' => 'me.update_password.post']);
		Route::post('/me/update-profile',						['uses' => 'MeController@post_update_profile',		'as' => 'me.update_profile.post']);

		Route::get('/settings',									['uses' => 'SettingController@index', 				'as' => 'settings.index']);
	});

});


Route::post('/sdm/login', [
    'as' => 'login',  'uses' 	=> 'AuthController@login'
]);

Route::any('/sdm/whoami', [
    'as' => 'whoami',  'uses' 	=> 'AuthController@whoami'
]);

Route::any('/hr/absent', [
    'as' => 'vision',  'uses' 	=> 'HRController@vision'
]);

Route::any('/hr/history', [
    'as' => 'history', 'uses' 	=> 'HRController@history'
]);


Route::any('/partner/rate', [
    'as' => 'rate',   'uses' 	=> 'PartnerController@rate'
]);

Route::any('/partner/point', [
    'as' => 'point',   'uses' 	=> 'PartnerController@point'
]);
