<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class UsersTest extends TestCase
{

    /**
     * @test
     */
    public function create_and_retrieve_user()
    {
        DB::beginTransaction();
        $user = new User([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password',
            'date' => now(),
            'camFoto' => 'image.png',
            'admin' => 1,
            'active' => 1,
        ]);
        $user->save();

        $userId = $user->id;
        $this->assertIsInt($userId);

        return ['user' => $user, 'id' => $userId];
    }

    /**
     * @test
     */
    public function it_has_solicitations_relation()
    {
        $user = new User();
        $relation = $user->solicitations();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $relation);
    }

    /**
     * @test
     */
    public function new_user()
    {
        DB::beginTransaction();
        $response = $this->post('/api/new_user', [
            'u_name' => 'John Doe',
            'u_email' => 'johndoe@example.com',
            'u_senha' => 'password',
            'u_confirm' => 'password',
            'tipo_user' => 'Admin',
        ]);

        // $response->assertStatus(200)
        //     ->assertJson([
        //         'status' => 1,
        //         'msg' => "Usuário cadastrado com sucesso!"
        //     ]);

        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function all_usersS()
    {
        $response = $this->get('/api/all_users_1');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function all_usersL()
    {
        $response = $this->get('/api/all_users_1L');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function get_by_id_user()
    {
        $response = $this->get('/api/usuario_by_id/' . 1);

        $response->assertStatus(200);
    }
}
