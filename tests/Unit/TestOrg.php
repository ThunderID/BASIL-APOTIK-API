<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestOrg extends TestCase
{
	protected $token;

	protected function setUp() : void
	{
		parent::setUp();

		\App\User::truncate();
		\App\Org::truncate();

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
		$this->token = $content->data->Authenticate->token;
	}

    public function testBasicRule()
    {
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
    }
}
