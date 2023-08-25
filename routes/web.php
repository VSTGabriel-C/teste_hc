<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MakeViews;
use App\Http\Controllers\Login\MakeLogin;
use App\Http\Controllers\Api\V_Solicitacoes\Visualizar_Solicitacoes;
use App\Http\Controllers\Api\Relatorios\Gerar_Relatorios;

Route::get('/', [MakeViews::class, 'makeViewLogin'])->name('hc_login');
Route::get('/make_relatorio', [MakeViews::class, 'makeViewRelatorios'])->name('hc.make.relatorio');
Route::get('/hc_transportes', [MakeViews::class, 'makeViewDashboard'])->name('hc.novaSolicitacao');
Route::get('/hc_lista_solicitacoes', [MakeViews::class, 'makeViewListaSolicitacao'])->name('hc.lista');
Route::get('/hc_add_remove_veiculo', [MakeViews::class, 'makeViewCad_Del_veiculo'])->name('hc.add_remove_view_veiculo');
Route::get('/hc_add_remove_motorista', [MakeViews::class, 'makeViewCad_Del_motorista'])->name('hc.add_remove_view_motorista');
Route::get('/hc_add_remove_solicitante', [MakeViews::class, 'makeViewCad_Del_Solicitante'])->name('hc.add_remove_view_solicitante');
Route::get('/hc_add_new_user', [MakeViews::class, 'makeView_new_User'])->name('hc_add_new_admin');
Route::get('/hc_edit_new_user', [MakeViews::class, 'makeView_edit_User'])->name('hc_edit_new_admin');
Route::get('/hc_infos', [MakeViews::class, 'makeView_Infos'])->name('hc_infos');
Route::get('/hc_aviso', [MakeViews::class,'makeView_Avisos'])->name('hc_aviso');
Route::get('hc_relatorios', [MakeViews::class, ''])->name('hc_relatorios');
Route::post('/hc_login_auth', [MakeLogin::class, 'autenticate'])->name('hc.autenticate');
Route::get('/deslogar', [MakeLogin::class, 'logout'])->name('hc.logoff');

Route::post('/relatorio', [Gerar_Relatorios::class, "gerar_Relatorio"])->name('hc.relatorio');
Route::get('/gerar-escala', [MakeViews::class, 'newScale'])->name('hc.new.scale');

Route::get('/testar/{id}', [Visualizar_Solicitacoes::class, 'teste']);
