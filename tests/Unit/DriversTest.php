<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Driver;
use App\Models\Solicitation;
use App\Models\DriverScale;
use Illuminate\Support\Facades\DB;

class DriverTest extends TestCase
{
    protected function createDriver()
    {
        return new Driver([
            'name' => 'John Doe',
            'status' => 1,
            'h_d' => 1,
            'motive' => 'Testing',
        ]);
    }

    /**
     * @test
     */
    public function create_and_retrieve_driver()
    {
        DB::beginTransaction();
        $driver = $this->createDriver();
        $driver->save();

        $driverId = $driver->id;
        $this->assertIsInt($driverId);

        return ['driver' => $driver, 'id' => $driverId];
    }

    /**
     * @test
     */
    public function it_has_solicitations_relation()
    {
        $driver = new Driver();
        $relation = $driver->solicitations();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $relation);
        $this->assertInstanceOf(Solicitation::class, $relation->getRelated());
    }

    /**
     * @test
     */
    public function it_has_driver_scales_relation()
    {
        $driver = new Driver();
        $relation = $driver->driverScales();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $relation);
        $this->assertInstanceOf(DriverScale::class, $relation->getRelated());
    }

    /**
     * @test
     */
    public function new_driver()
    {
        DB::beginTransaction();
        $response = $this->post('/api/add_new_motorista', [
            'name' => 'TestDriver'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 1,
                'msg' => "Novo motorista cadastrado com sucesso!"
            ]);
    }

    /**
     * @test
     */
    public function get_drivers()
    {
        $response = $this->get('/api/motorista_all');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function get_allL_drivers()
    {
        $response = $this->get('/api/motorista_allL');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function available_drivers()
    {
        $response = $this->get('/api/get_motorista_disponivel');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function able_drivers()
    {
        $response = $this->get('/api/get_motorista_habilitado');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function get_by_id_driver()
    {
        $response = $this->get('/api/get_motorista_by_id/' . 1);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function delete_driver()
    {
        DB::beginTransaction();
        $response = $this->post('/api/motorista_delete', [
            'id' => 1,
            'mot' => 'Motivo da ação'
        ]);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function edit_driver()
    {
        DB::beginTransaction();
        $response = $this->post('/api/motorista_edit', [
            'id' => 8,
            'nome' => 'teste321'
        ]);

        $response->assertStatus(200);
    }
}
