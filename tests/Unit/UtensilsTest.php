<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Utensils;
use App\Models\Solicitation;

class UtensilsTest extends TestCase
{
    protected function create_utensils()
    {
        return new Utensils([
            'oxygen' => 'Yes',
            'obese' => 'No',
            'isolate' => 'Yes',
            'stretcher' => 'No',
            'isolation' => 'Yes',
            'death' => 'No',
            'uti' => 'Yes',
            'd_isolation' => 'High Risk',
        ]);
    }

    /**
     * @test
     */
    public function create_and_retrieve_utensils()
    {

        $utensil = $this->create_utensils();

        $utensil->save();

        $utensilId = $utensil->id;

        $this->assertIsInt($utensilId);

        return ['utensil' => $utensil, 'id' => $utensilId];
    }

        /**
     * @test
     */
    public function it_has_solicitations_relation()
    {
        $utensils = new Utensils();
        $relation = $utensils->solicitations();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $relation);
        $this->assertInstanceOf(Solicitation::class, $relation->getRelated());
    }
}

