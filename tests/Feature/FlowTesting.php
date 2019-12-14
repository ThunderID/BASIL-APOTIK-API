<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class FlowTesting extends TestCase
{
	use RefreshDatabase;

	protected $jwt; 
	protected $username; 

    // protected function setUp(): void
    // {
    // 	parent::setUp();

    // 	\App\User::truncate();
    // 	\App\Work::truncate();
    // }

	public function testRegister()
	{
		/*================================
		=            REGISTER            =
		================================*/
		
		$response = $this->post('/graphql', 
			[
				'query' => 'mutation reg {
					Register(name:"Erick", username:"628113037875", password:"123123123") {
						name
						email
						username
						username_verified_at
					}
				}'
			]
		);
		$content = json_decode($response->getContent());
		$this->username = $content->data->Register->username;
		$this->assertNotNull($this->username);
		/*=====  End of REGISTER  ======*/

		/*============================================
		=            Reset Password Token            =
		============================================*/

		$response = $this->post('/graphql', 
			[
				'query' => 'mutation forgetPass {
					ForgetPassword(username:"628113037875") 
				}'
			]
		);
		$content = json_decode($response->getContent());
		$this->assertTrue($content->data->ForgetPassword);

		$user = User::first();
		$this->assertNotNull($user->reset_password_token);
		$reset_password_token = $user->reset_password_token->token;
		
		/*=====  End of Reset Password Token  ======*/



		/*======================================
		=            Reset Password            =
		======================================*/
		
		$response = $this->post('/graphql', 
			[
				'query' => 'mutation resetPassword {
					ResetPasswordWithToken(username:"628113037875" token:"'.$reset_password_token.'" password:"123123123") 
				}'
			]
		);

		$content = json_decode($response->getContent());
		$this->assertTrue($content->data->ResetPasswordWithToken);

		/*=====  End of Reset Password  ======*/


		
		/*====================================
		=            AUTHENTICATE            =
		====================================*/
		
		$response = $this->post('/graphql', 
			[
				'query' => 'mutation auth{
					Authenticate(username:"628113037875", password:"123123123") {
						token,
						user {
							name
							email
							username
							username_verified_at
						}
					}
				}'
			]
		);
		$content = json_decode($response->getContent());
		$this->token = $content->data->Authenticate->token;
		$this->assertNotNull($this->token);
		
		/*=====  End of AUTHENTICATE  ======*/


		/*=======================================
		=            UpdateMyProfile            =
		=======================================*/
				
		$response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
						 ->post('/graphql', 
								[
									'query' => 'mutation auth{
										UpdateMyProfile(name:"E.Mo", email:"mo@intinusa.id") {
											name
										}
									}'
								]
							);
		$content = json_decode($response->getContent());
		$this->assertTrue($content->data->UpdateMyProfile->name == "E.Mo");
				
		/*=====  End of UpdateMyProfile  ======*/

		/*=======================================
		=            UpdateMyPassword            =
		=======================================*/
				
		$response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
						 ->post('/graphql', 
								[
									'query' => 'mutation auth{
										UpdateMyPassword(old_password:"123123123", new_password:"123123123") 
									}'
								]
							);
		$content = json_decode($response->getContent());
		$this->assertTrue($content->data->UpdateMyPassword);
				
		/*=====  End of UpdateMyPassword  ======*/

		/*======================================
		=            Store OrgGroup            =
		======================================*/

		/*----------  ORG 1  ----------*/
		$response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
						 ->post('/graphql', [
									'query' => 'mutation StoreOrgGroup{
										StoreOrgGroup(
											name: "Riverstone"
										) {
											name
											id
											owner {
												username
											}
										}
									}
									'
								]
							 );
		$content = json_decode($response->getContent());
		$org_group_id_1 = $content->data->StoreOrgGroup->id;

		$this->assertNotNull($content->data->StoreOrgGroup->id);
		$this->assertTrue($content->data->StoreOrgGroup->owner->username == '628113037875');
		
		/*----------  ORG 2  ----------*/
		$response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
						 ->post('/graphql', [
									'query' => 'mutation StoreOrgGroup{
										StoreOrgGroup(
											name: "Kontena"
										) {
											name
											id
											owner {
												username
											}
										}
									}
									'
								]
							 );
		$content = json_decode($response->getContent());
		$org_group_id_2 = $content->data->StoreOrgGroup->id;
		$this->assertNotNull($content->data->StoreOrgGroup->id);

		/*=====  End of StoreOrgGroup  ======*/
		
		


		/*=================================
		=            Add Org             =
		=================================*/

		/*----------  ORG 1  ----------*/
		$response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
						 ->post('/graphql', [
									'query' => 'mutation StoreOrg{
										StoreOrg(
											org_group_id: '.$org_group_id_1.'
											name: "Riverstone"
											address: "KH Agus Salim 97"
											city: "Batu"
											province: "Jawa Timur"
											country: "Indonesia"
											phone: "0341-524414"
										) {
											id
											name
											org_group {
												owner {
													username
												}
											}
										}
									}
									'
								]
							 );
		$content = json_decode($response->getContent());
		$org_id_1 = $content->data->StoreOrg->id;

		$this->assertNotNull($content->data->StoreOrg->id);
		$this->assertTrue($content->data->StoreOrg->org_group->owner->username == '628113037875');

		/*----------  ORG 2  ----------*/
		$response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
						 ->post('/graphql', [
									'query' => 'mutation StoreOrg{
										StoreOrg(
											org_group_id: 2
											name: "Kontena"
											address: "KH Agus Salim 97"
											city: "Batu"
											province: "Jawa Timur"
											country: "Indonesia"
											phone: "0341-524414"
										) {
											id
											name
											org_group {
												owner {
													username
												}
											}
										}
									}
									'
								]
							 );
		$content = json_decode($response->getContent());
		$org_id_2 = $content->data->StoreOrg->id;

		$this->assertNotNull($content->data->StoreOrg->id);
		$this->assertTrue($content->data->StoreOrg->org_group->owner->username == '628113037875');

		/*=====  End of Add Hotel  ======*/

		/*====================================
		=            Update Org 1            =
		====================================*/
		$response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
						 ->post('/graphql', [
									'query' => 'mutation StoreOrg{
										StoreOrg(
											id: '. $org_id_1 .'
											name: "Riverstone Hotel & Cottage"
											address: "KH Agus Salim 97"
											city: "Batu"
											province: "Jawa Timur"
											country: "Indonesia"
											phone: "0341-524414"
										) {
											id
											name
											org_group {
												owner {
													username
												}
											}
										}
									}
									'
								]
							 );
		$content = json_decode($response->getContent());
		$this->assertTrue($content->data->StoreOrg->name == 'Riverstone Hotel & Cottage');

		/*=====  End of Update Hotel  ======*/
		
		/*====================================
		=            Add RoomType            =
		====================================*/

		/*----------  ORG 1  ----------*/
		$response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
						 ->post('/graphql', [
									'query' => 'mutation StoreRoomType {
										StoreRoomType (
											org_id: ' . $org_id_1 . '
											name: "Family Room"
											description: "3 adult 2 children"
										) {
											id
											name
											org {
												id
												name
											}
											description
										}
									}
									'
								]
							 );

		$content = json_decode($response->getContent());
		$room_type_id_org_1 = $content->data->StoreRoomType->id;

		$this->assertNotNull($content->data->StoreRoomType->id);

		/*----------  ORG 2  ----------*/
		$response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
						 ->post('/graphql', [
									'query' => 'mutation StoreRoomType {
										StoreRoomType (
											org_id: ' . $org_id_2 . '
											name: "Family Room"
											description: "3 adult 2 children"
										) {
											id
											name
											org {
												id
												name
											}
											description
										}
									}
									'
								]
							 );

		$content = json_decode($response->getContent());
		$room_type_id_org_2 = $content->data->StoreRoomType->id;

		$this->assertNotNull($content->data->StoreRoomType->id);

		
		/*=====  End of Add RoomType  ======*/

		/*========================================
		=            Update Room Type            =
		========================================*/
		
		/*----------  ORG 1  ----------*/
		$response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
						 ->post('/graphql', [
									'query' => 'mutation StoreRoomType {
										StoreRoomType (
											id: ' . $room_type_id_org_1 . '
											org_id: ' . $org_id_1 . '
											name: "Family Room Basic"
											description: "2 adult 2 children"
										) {
											id
											name
											org {
												id
												name
											}
											description
										}
									}
									'
								]
							 );
		$content = json_decode($response->getContent());
		$this->assertTrue($content->data->StoreRoomType->name == 'Family Room Basic');
		
		/*=====  End of Update Room Type  ======*/
		
		

		/*================================
		=            Add Room            =
		================================*/
		/*----------  ORG 1  ----------*/
		$response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
						 ->post('/graphql', [
									'query' => 'mutation StoreRoom{
										StoreRoom(
											org_id: ' . $org_id_1 . '
											room_type_id: ' . $room_type_id_org_1 . '
											name: "101"
											description: "Room 101"
										) {
											id
											name
										}
									}
									'
								]
							 );
		$content = json_decode($response->getContent());
		$room_id_org_1 = $content->data->StoreRoom->id;
		
		$this->assertNotNull($room_id_org_1);

		/*----------  EDIT TO ORG 2  ----------*/
		$response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
						 ->post('/graphql', [
									'query' => 'mutation StoreRoom{
										StoreRoom(
											id: ' . $room_id_org_1 . '
											org_id: ' . $org_id_2 . '
											room_type_id: ' . $room_type_id_org_2 . '
											name: "101"
											description: "Room 101"
										) {
											id
											name
										}
									}
									'
								]
							 );
		$content = json_decode($response->getContent());
		
		$this->assertContains('immutable', $content->errors[0]->validation->org_id);


		/*==========================================
		=            Update Room Status            =
		==========================================*/
		$response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
						 ->post('/graphql', [
									'query' => 'mutation UpdateRoomStatus{
										UpdateRoomStatus(
											room_id: ' . $room_id_org_1 . '
											status: "VACANT_CLEAN"
										)
									}
									'
								]
							 );
		$content = json_decode($response->getContent());
		$this->assertTrue(in_array('invalid:in:VACANT_DIRTY', $content->errors[0]->validation->status));

		$response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
						 ->post('/graphql', [
									'query' => 'mutation UpdateRoomStatus{
										UpdateRoomStatus(
											room_id: ' . $room_id_org_1 . '
											status: "VACANT_DIRTY"
										)
									}
									'
								]
							 );
		$content = json_decode($response->getContent());
		$this->assertTrue($content->data->UpdateRoomStatus);
		
		/*=====  End of Update Room Status  ======*/


		/*============================
		=            Book            =
		============================*/
		$response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
						 ->post('/graphql', [
									'query' => 'mutation StoreBooking{
										StoreBooking(
											user_id: ' . User::first()->id . '
											org_id: ' . $org_id_1 . '
											ci_date: "' . now()->format('Y-m-d') . '"
											co_date: "' . now()->addDay()->format('Y-m-d') . '"
											lines: [
												{
													room_type_id: ' . $room_type_id_org_1 . '
													qty: 2
												}
											]
										) {
											id
										}
									}
									'
								]
							 );
		$content = json_decode($response->getContent());
		$this->assertNotNull($content->data->StoreBooking->id);

		// Check room reservation is also created
		$this->assertNotNull(\App\RoomAvailability::get());
		
		/*=====  End of Book  ======*/
		
		
		
	}
}
