<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Vehicle;
use App\Models\Solicitation;
use App\Models\VehicleScale;
use Illuminate\Support\Facades\DB;

class VehicleTest extends TestCase
{
    protected function createVehicle()
    {
        return Vehicle::create([
            'type' => 'Sedan',
            'pref' => 'ABC123',
            'plate' => 'XYZ 789',
            'brand' => 'Some Brand',
            'status' => 'Active',
            'h_d' => 'Some Value',
            'motive' => 'Testing',
            'email' => 'example@example.com',
        ]);
    }

    /**
     * @test
     */
    public function create_and_retrieve_vehicle()
    {
        DB::beginTransaction();
        $vehicle = $this->createVehicle();

        $vehicleId = $vehicle->id;
        $this->assertIsInt($vehicleId);

        return ['vehicle' => $vehicle, 'id' => $vehicleId];
    }

    /**
     * @test
     */
    public function it_has_solicitations_relation()
    {
        DB::beginTransaction();
        $vehicle = new Vehicle();
        $relation = $vehicle->solicitations();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $relation);
        $this->assertInstanceOf(Solicitation::class, $relation->getRelated());
    }

    /**
     * @test
     */
    public function it_has_vehicle_scales_relation()
    {
        DB::beginTransaction();
        $vehicle = new Vehicle();
        $relation = $vehicle->vehicleScales();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $relation);
        $this->assertInstanceOf(VehicleScale::class, $relation->getRelated());
    }

    /**
     * @test
     */
    public function new_vehicle()
    {
        DB::beginTransaction();
        $response = $this->post('/api/add_new_veiculo', [
            'pref' => '423',
            'placa' => 'ABC123',
            'tipo' => 'Carro',
            'marca' => 'Toyota'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 1,
                'msg' => "Veiculo cadastrado com sucesso!"
            ]);
    }

    /**
     * @test
     */
    public function get_vehicle()
    {
        $response = $this->get('/api/veiculo_all');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function get_by_id_vehicle()
    {
        $response = $this->get('/api/get_veiculo_by_id/' . 1);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function available_vehicle()
    {
        $response = $this->get('/api/get_veiculo_disponivel');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function albe_vehicle()
    {
        $response = $this->get('/api/get_veiculo_habilitado');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function delete_vehicle()
    {
        DB::beginTransaction();
        $response = $this->post('/api/veiculo_delete', [
            'id' => 1,
            'motivo' => 'Motivo da ação'
        ]);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function edit_vehicle()
    {
        DB::beginTransaction();
        $response = $this->post('/api/veiculo_edit', [
            'id' => 1,
            'pref' => '456',
            'tipo' => 'Van',
            'placa' => 'XYZ789',
            'marca' => 'Ford'
        ]);

        $response->assertStatus(200);
    }
}
