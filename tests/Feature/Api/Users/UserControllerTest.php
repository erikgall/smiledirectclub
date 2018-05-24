<?php

namespace Tests\Feature\Api\Users;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * User API controller test.
 *
 * @author Erik Galloway <erik@fliplearning.com>
 */
class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test fetching all users from the api.
     *
     * @return void
     */
    public function testFetchingAllUsers(): void
    {
        $males = factory(User::class, 2)->states('male')->create();
        $females = factory(User::class, 2)->states('female')->create();

        $users = $males->merge($females);

        $response = $this->getJson('api/users');

        $response->assertStatus(200);

        $response->assertExactJson($users->toArray());
    }

    /**
     * Test fetching a specific user by id.
     *
     * @return void
     */
    public function testFetchingAUserById(): void
    {
        $user = factory(User::class)->create();

        $response = $this->getJson("api/users/{$user->id}");

        $response->assertStatus(200);

        $response->assertExactJson($user->toArray());
    }

    /**
     * Test fetching a non-existent user & handling the error..
     *
     * @return void
     */
    public function testFetchingAUserWhoDoesNotExist(): void
    {
        $response = $this->getJson('api/users/51515');

        $response->assertStatus(404);

        $response->assertExactJson([
            'message' => 'The user was not found.',
        ]);
    }

    /**
     * Test creating and storing a new user model.
     *
     * @return void
     */
    public function testCreatingANewUser(): void
    {
        $response = $this->postJson('api/users', ['name' => $name = $this->faker()->name, 'email' => $email = $this->faker()->unique()->safeEmail]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', ['email' => $email]);

        $user = User::whereEmail($email)->first();

        $response->assertExactJson([
            'message' => 'Success! The user was registered successfully.',
            'data'    => $user->toArray(),
        ]);
    }
}
