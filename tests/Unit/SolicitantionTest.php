<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Solicitation;
use App\Models\User;
use App\Models\Applicant;
use App\Models\DirCh;
use App\Models\Utensils;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\DirGoing;
use App\Models\DirReturn;
use App\Models\DistancePerc;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SolicitationTest extends TestCase
{
    /**
     * @test
     */
    public function it_has_fillable_fields()
    {
        $solicitation = new Solicitation();
        $fillable = $solicitation->getFillable();

        $expectedFillable = [
            'date',
            'hour',
            'destiny',
            'ordinance',
            'end_loc_ident',
            'going',
            'return',
            'cancellation',
            'n_file',
            'hc',
            'incor',
            'radio',
            'contact_plant',
            'attendance_by',
            'observation',
            'status_sol',
            'fk_user',
            'fk_ramal',
            'fk_applicant',
            'fk_utensil',
            'fk_vehicle',
            'fk_driver',
            'fk_dist_perc',
            'fk_patient'
        ];

        $this->assertEquals($expectedFillable, $fillable);
    }

    /**
     * @test
     */
    public function it_belongs_to_user()
    {
        $solicitation = new Solicitation();
        $relation = $solicitation->user();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
        $this->assertInstanceOf(User::class, $relation->getRelated());
    }

    /**
     * @test
     */
    public function it_belongs_to_applicant()
    {
        $solicitation = new Solicitation();
        $relation = $solicitation->applicant();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
        $this->assertInstanceOf(Applicant::class, $relation->getRelated());
    }

    /**
     * @test
     */
    public function it_belongs_to_utensils()
    {
        $solicitation = new Solicitation();
        $relation = $solicitation->utensils();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
        $this->assertInstanceOf(Utensils::class, $relation->getRelated());
    }

    /**
     * @test
     */
    public function it_belongs_to_vehicle()
    {
        $solicitation = new Solicitation();
        $relation = $solicitation->vehicle();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
        $this->assertInstanceOf(Vehicle::class, $relation->getRelated());
    }

    /**
     * @test
     */
    public function it_belongs_to_driver()
    {
        $solicitation = new Solicitation();
        $relation = $solicitation->driver();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
        $this->assertInstanceOf(Driver::class, $relation->getRelated());
    }

    /**
     * @test
     */
    public function it_belongs_to_patient()
    {
        $solicitation = new Solicitation();
        $relation = $solicitation->patient();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
        $this->assertInstanceOf(Patient::class, $relation->getRelated());
    }

    /**
     * @test
     */
    public function it_belongs_to_dirGoings()
    {
        $solicitation = new Solicitation();
        $relation = $solicitation->dirGoings();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
        $this->assertInstanceOf(DirGoing::class, $relation->getRelated());
    }

    /**
     * @test
     */
    public function it_belongs_to_dirChs()
    {
        $solicitation = new Solicitation();
        $relation = $solicitation->dirChs();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
        $this->assertInstanceOf(DirCh::class, $relation->getRelated());
    }

    /**
     * @test
     */
    public function it_belongs_to_dirReturns()
    {
        $solicitation = new Solicitation();
        $relation = $solicitation->dirReturns();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
        $this->assertInstanceOf(DirReturn::class, $relation->getRelated());
    }

    /**
     * @test
     */
    public function it_belongs_to_distancePercs()
    {
        $solicitation = new Solicitation();
        $relation = $solicitation->distancePercs();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);
        $this->assertInstanceOf(DistancePerc::class, $relation->getRelated());
    }
}
