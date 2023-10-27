<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Driver;
use App\Models\Solicitation;
use App\Models\DriverScale;
use Illuminate\Support\Facades\DB;

class InformationsTest extends TestCase
{
    /**
     * @test
     */
    public function get_solicitations()
    {
        $response = $this->get('/api/get_solicitation');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function get_solicitations_pie()
    {
        $response = $this->get('/api/get_solicitationPIE');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function get_media_kilometragem()
    {
        $response = $this->get('/api/media_kilometragem');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function get_concluidas()
    {
        $response = $this->get('/api/get_Concluidas', [
            'data' => '2023-10-10'
        ]);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function get_diarias()
    {
        $response = $this->get('/api/get_Diarias', [
            'data' => '2023-10-10'
        ]);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function get_andamento()
    {
        $response = $this->get('/api/get_Andamento', [
            'data' => '2023-10-10'
        ]);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function get_cancelamento()
    {
        $response = $this->get('/api/get_cancelamento');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function get_cancelamento_modal()
    {
        $response = $this->get('/api/get_CancelamentoModal', [
            'data' => '2023-10-10'
        ]);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function get_quilometragem_modal()
    {
        $response = $this->get('/api/get_QuilometragemModal');

        $response->assertStatus(200);
    }
}
