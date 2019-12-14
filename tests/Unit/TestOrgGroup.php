<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestOrgGroup extends TestCase
{
	protected $token1;
	protected $token2;

	protected function setUp() : void
	{
		parent::setUp();

		\App\User::truncate();
		\App\OrgGroup::truncate();

		/*----------  USER 1  ----------*/
		\App\User::create([
			'name'     => "Erick",
			'username' => '628113037875',
			'password' => '123123123'
		]);

		
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
		$this->token1 = $content->data->Authenticate->token;


		/*----------  USER 2  ----------*/
		\App\User::create([
			'name'     => "X",
			'username' => '6281333517875',
			'password' => '123123123'
		]);

		$response = $this->post('/graphql', 
			[
				'query' => 'mutation auth{
					Authenticate(username:"6281333517875", password:"123123123") {
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
		$this->token2 = $content->data->Authenticate->token;
	}

    public function testUserCreateOwnOrgGroup()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token1)
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

		/*----------  Assert Saved  ----------*/
		$this->assertNotNull($content->data->StoreOrgGroup->id);

		/*----------  Assert User as Owner  ----------*/
		$this->assertTrue($content->data->StoreOrgGroup->owner->username == '628113037875');
    }

    public function testUserCreateDuplicatedOrgGroup()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token1)
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

		$response = $this->withHeader('Authorization', 'Bearer ' . $this->token1)
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

		/*----------  Assert Duplicated  ----------*/
		$this->assertContains('unique', $content->errors[0]->validation->name);
    }

    public function testUserEditOrgGroup()
    {
    	/*----------  Create  ----------*/
		$response = $this->withHeader('Authorization', 'Bearer ' . $this->token1)
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
		$id = $content->data->StoreOrgGroup->id;


    	/*----------  Edit  ----------*/
		$new_name = "Riverstone Hotel & Cottage";
		$response = $this->withHeader('Authorization', 'Bearer ' . $this->token1)
						 ->post('/graphql', [
									'query' => "mutation StoreOrgGroup{
										StoreOrgGroup(
											id: $id
											name: \"$new_name\"
										) {
											name
											id
											owner {
												username
											}
										}
									}
									"
								]
							 );
		$content = json_decode($response->getContent());

		/*----------  Assert Updated ----------*/
		$this->assertEquals($new_name, $content->data->StoreOrgGroup->name);
    }
}
