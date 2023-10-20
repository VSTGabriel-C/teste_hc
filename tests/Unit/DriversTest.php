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
}
