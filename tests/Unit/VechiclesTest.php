<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Vehicle;
use App\Models\Solicitation;
use App\Models\VehicleScale;

class VehicleTest extends TestCase
{
    protected function createVehicle()
    {
        return new Vehicle([
            'type' => 'Sedan',
            'pref' => 'ABC 123',
            'plate' => 'XYZ 789',
            'brend' => 'Some Brand',
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
        $vehicle = $this->createVehicle();
        $vehicle->save();

        $vehicleId = $vehicle->id;
        $this->assertIsInt($vehicleId);

        return ['vehicle' => $vehicle, 'id' => $vehicleId];
    }

    /**
     * @test
     */
    public function it_has_solicitations_relation()
    {
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
        $vehicle = new Vehicle();
        $relation = $vehicle->vehicleScales();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $relation);
        $this->assertInstanceOf(VehicleScale::class, $relation->getRelated());
    }
}
