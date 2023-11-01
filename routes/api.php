<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Motorista\NewMotorista;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\Motorista\ExcludeMotorista;
use App\Http\Controllers\Api\Motorista\EditMotorista;
use App\Http\Controllers\Api\Veiculo\NewVeiculo;
use App\Http\Controllers\Api\Veiculo\Veiculo_Get_Data;
use App\Http\Controllers\Api\Veiculo\ExcludeVeiculo;
use App\Http\Controllers\Api\Veiculo\EditVeiculo;
use App\Http\Controllers\Api\Solicitante\NewSolicitante;
use App\Http\Controllers\Api\Solicitante\EditSolicitante;
use App\Http\Controllers\Api\Solicitante\ExcludeSolicitante;
use App\Http\Controllers\Api\NewSolicitations;
use App\Http\Controllers\Api\Teste;
use App\Http\Controllers\Api\V_Solicitacoes\Visualizar_Solicitacoes;
use App\Http\Controllers\Api\V_Solicitacoes\Editar_Solicitacoes;
use App\Http\Controllers\Api\Usuarios\NewUser;
use App\Http\Controllers\Api\Usuarios\EditarUser;
use App\Http\Controllers\Api\Usuarios\DesabilitarUser;
use App\Http\Controllers\Login\MakeLogin;
use App\Http\Controllers\Api\Apis_Infos\V_informacoes;
use App\Http\Controllers\Api\Avisos\Avisos;
use App\Http\Controllers\Api\Apis_Infos\Warnings;
use App\Http\Controllers\Api\Escala\Escala;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/get_solicitations_filter', [Visualizar_Solicitacoes::class, 'searchSolicitations'])
    ->name('hc.api.get_solicitations_filter');

Route::get('/get_solicitations_filterDIA', [Visualizar_Solicitacoes::class, 'searchSolicitationsDIA'])
    ->name('hc.api.get_solicitationsDIA_filter');

Route::get('/get_solicitations_filter_by_id/{id}', [Visualizar_Solicitacoes::class, 'searchSolicitationById'])
    ->name('hc.api.get_solicitations_byId');

Route::post('/get_All_by_id/{id}', [Editar_Solicitacoes::class, 'editar_solicitacoes'])
    ->name('hc.api.get_solicitations_byId');




Route::post('/login', [AuthController::class, 'login']); // feito

//ROTAS SOLICITACOES
Route::post('/new_solicitation', [NewSolicitations::class, 'newSolicitation'])->name('hc.api.newSolicitation'); // feito

Route::get('/solicitations_all', [Visualizar_Solicitacoes::class, 'getAllSolicitations']); // Feito

//ROTAS MOTORISTA
Route::get('/motorista_all', [NewMotorista::class, 'getMotorista'])->name('hc.api.getMotorista'); // Feito
Route::get('/motorista_allL', [NewMotorista::class, 'getMotoristaL'])->name('hc.api.getMotoristaL'); // Feito
Route::get('/get_motorista_disponivel', [NewMotorista::class, 'getMotoristaDisponivel'])->name('hc.api.getMotorista.disponivel'); // Feito
Route::get('/get_motorista_habilitado', [NewMotorista::class, 'getMotoristaHabilitado'])->name('hc.api.getMotorista.habilitado'); // Feito
Route::get('/get_motorista_by_id/{id}', [NewMotorista::class, 'getMotoristaById'])->name('hc.api.getMotoristaById'); // Feito

Route::post('/add_new_motorista', [NewMotorista::class, 'newMotorista'])->name('hc.api.newMotorista'); // Feito
Route::post('/motorista_delete', [ExcludeMotorista::class, 'excludeMotorista'])->name('hc.api.excludeMotorista'); //Feito
Route::post('/motorista_edit', [EditMotorista::class, 'editMotorista'])->name('hc.api.editMotorista'); // Feito

//ROTAS VEICULO
Route::get('/veiculo_all', [Veiculo_Get_Data::class, 'getVeiculos'])->name('hc.api.getVeiculo'); // Feito
Route::get('/get_veiculo_by_id/{id}', [Veiculo_Get_Data::class, 'getVeiculoById'])->name('hc.api.getVeiculoById'); // Feito
Route::get('/get_veiculo_disponivel', [Veiculo_Get_Data::class, 'getVeiculoDisponivel'])->name('hc.api.getVeiculoDisponivel'); // Feito
Route::get('/get_veiculo_habilitado', [Veiculo_Get_Data::class, 'getVeiculoHabilitado'])->name('hc.api.getVeiculoHabilitado'); // Feito

Route::post('/add_new_veiculo', [NewVeiculo::class, 'newVeiculo'])->name('hc.api.add_new_veiculo'); // Feito
Route::post('/veiculo_delete', [ExcludeVeiculo::class, 'excludeVeiculo'])->name('hc.api.veiculo_delete'); // Feito
Route::post('/veiculo_edit', [EditVeiculo::class, 'editVeiculo'])->name('hc.api.veiculo_edit'); // Feito

//ROTAS SOLICITANTE
Route::get('/solicitante_all', [NewSolicitante::class, 'getSolicitante'])->name('hc.api.solicitante_all'); // Feito
Route::get('/solicitante_allS', [NewSolicitante::class, 'getSolicitanteS'])->name('hc.api.solicitante_allS'); // Feito
Route::get('/solicitante_all_condition', [NewSolicitante::class, 'getSolicitante_condition'])->name('hc.api.solicitante_all_condition'); // Feito
Route::get('/get_solicitante_by_id/{id}', [NewSolicitante::class, 'getSolicitanteById'])->name('hc.api.editSolicitanteById'); // Feito

Route::post('/add_new_solicitante', [NewSolicitante::class, 'newSolicitante'])->name('hc.api.add_new_solicitante'); // Feito
Route::post('/add_new_solicitante_bot', [NewSolicitante::class, 'newSolicitante_bot'])->name('hc.api.add_new_solicitante_bot'); // Feito
Route::post('/edit_solicitante', [EditSolicitante::class, 'editSolicitante'])->name('hc.api.editSolicitante'); // Feito
Route::post('/delete_solicitante', [ExcludeSolicitante::class, 'excludeSolicitante'])->name('hc.api.deleteSolicitante'); // Feito


//ROTAS USUARIO
Route::get('/all_users_1', [EditarUser::class, 'allUserss'])->name('hc.api.get_All_Users'); // Feito
Route::get('/all_users_1L', [EditarUser::class, 'allUserssL'])->name('hc.api.get_All_UsersL'); // Feito
Route::get('/usuario_by_id/{id}', [EditarUser::class, 'get_Users_By_Id'])->name('hc.api.get_Users_By_Id'); // Feito

Route::post('/new_user', [NewUser::class, 'newUser'])->name('hc.api.new_user'); // Feito
Route::post('/habilitar_desabilitar', [DesabilitarUser::class, 'hbl_desb'])->name('hc.api.edit_User_By_Id'); // Feito
Route::post('/edit_usuario_by_id', [EditarUser::class, 'edit_User_By_Id'])->name('hc.api.edit_User_By_Ids'); // Feito

//API DESLOG
Route::get("/deslogar_user", [MakeLogin::class, "logout"])->name("hc.api.deslogar_user"); // Feito


//APIS INFORMAÇÔES
Route::get("/get_solicitation", [V_informacoes::class, "number_Solicitations"])->name("hc.api.numbe_sol"); // Feito
Route::get("/get_solicitationPIE", [V_informacoes::class, "number_SolicitationsPIE"])->name("hc.api.numbe_solPIE"); // Feito
Route::get("/media_kilometragem", [V_informacoes::class, "mediaKilometragem"])->name("hc.api.numbe_sol"); // Feito
//Route::get("/card_dados_anual", [V_informacoes::class, "card_dados_anual"])->name("hc.api.km_mes"); // --
Route::get("/get_Concluidas", [V_informacoes::class, "get_concluidas"])->name("hc.api.Concluidas"); // Feito
Route::get("/get_Diarias", [V_informacoes::class, "get_Diarias"])->name("hc.api.Diarias"); // Feito
Route::get("/get_Andamento", [V_informacoes::class, "get_Andamento"])->name("hc.api.Andamento"); // Feito
Route::get("/get_cancelamento", [V_informacoes::class, "get_Cancelamentos"])->name("hc.api.Cancelamento"); // Feito
Route::get("/get_CancelamentoModal", [V_informacoes::class, "get_CancelamentoModal"])->name("hc.api.CancelamentoModal"); // Feito
Route::get("/get_QuilometragemModal", [V_informacoes::class, "get_QuilometragemModal"])->name("hc.api.QuilometragemModal"); // Feito


//ESCALAS
Route::get('/get-all-escalas', [Escala::class, 'getAllEscalasController']); // Feito
Route::get('/active-deactive', [Escala::class, 'activeDeactive']); // Feito
Route::get('/retrieve-motoristas-by-escala-active', [Escala::class, 'retrieveMotoristaByEscalaActiveController']); // Feito
Route::get('/retrieve-veiculos-by-escala-active', [Escala::class, 'retrieveVeiculosByEscalaActiveController']); // Feito

Route::post("/new-escala", [Escala::class, 'newEscalaController'])->name('hc.api.newEscala'); // Feito
Route::post("/get-all-escalas-by", [Escala::class, 'getEscalaDataByFilter']); // Feito
Route::post("/get-all-escalas-filter", [Escala::class, 'getAllEscalasByFilter']); // Feito
Route::post("/exclude-escala", [Escala::class, 'excludeEscala']); // Feito
Route::post("/edit-escala", [Escala::class, 'editEscala']); // feito

Route::post("/expire-escala", [Escala::class, "verifyExpireEscalas"]); // Feito

// TESTE
Route::get('/teste', [Teste::class, 'teste'])->name('hc.api.d');

//Rotas Avisos

Route::get('/get_avisos', [Avisos::class, 'getAvisos'])->name('hc.api.getAvisos');
Route::get('/warnings', [Warnings::class, "makeMsg"])->name("hc.api.Warning");
