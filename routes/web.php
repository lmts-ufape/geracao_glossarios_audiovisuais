<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Rota raiz
Route::get('/', function () {
    return view('letras');
})->name('glossario');

// Checa o prefixo para o idioma correto
Route::prefix(parseLocale())->group(function () {
    Route::get('/', function () {
        return view('letras');
    })->name('glossario');

    // Rotas padrão
    Route::get('/login', function() {
        return view('auth.login');
    })->name('login');

    Route::get('/logout', 'HomeController@logout')->name('logout');

    Route::get('/letra/{l}', 'ListarVerbeteController@listar')->name('letra');

    Route::get('/verbete/{id}', 'ListarTrechoController@listar')->name('verbete');

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/letras', 'ViewsController@glossario')->name('letras');
    Route::get('/listar-todas-as-palavras', 'ViewsController@listarPalavras')->name('listarPalavras');

    // Rotas da pesquisa
    Route::get('/pesquisa', 'ViewsController@pesquisa')->name('pesquisa');
    Route::any('/pesquisar', 'PesquisaController@novaPesquisa')->name('pesquisa.nova');
    Route::any('/pesquisar/{id}', 'PesquisaController@pesquisaId')->name('pesquisa.id');

    // Rota para contabilizar a view do vídeo ou áudio
    Route::get('/contarView/{id}', 'ViewsController@contarView')->name('contarView');

    // Rotas para administrar os trechos
    Route::get('/editar/trecho/{id}', 'TrechoController@index')->name('editar')->middleware('auth');
    Route::any('/salvar/trecho/{id}', 'TrechoController@update')->name('editar.update')->middleware('auth');
    Route::get('/adicionar/trecho/{id}', 'TrechoController@adicionar')->name('trecho.add')->middleware('auth');
    Route::post('/adicionar/trecho/salvar/{id}', 'TrechoController@salvar')->name('trecho.add.save')->middleware('auth');
    Route::get('/excluir/trecho/{id}', 'TrechoController@deletar')->name('trecho.del')->middleware('auth');

    // Rotas para administrar os verbetes
    Route::get('/adicionar/verbete', 'VerbeteController@exibir')->name('verbete.add')->middleware('auth');
    Route::any('/adicionar/verbete/salvar', 'VerbeteController@adicionar')->name('verbete.add.save')->middleware('auth');
    Route::post('/editar/verbete/{id}', 'VerbeteController@editar')->name('verbete.edit')->middleware('auth');
    Route::get('/excluir/verbete/{id}', 'VerbeteController@deletar')->name('verbete.del')->middleware('auth');

    // Rotas de download dos arquivos
    Route::get('/baixar/arquivo-sd/{id}', 'TrechoController@baixarSD')->name('baixar.arquivo_sd')->middleware('auth');
    Route::get('/baixar/arquivo-hd/{id}', 'TrechoController@baixarHD')->name('baixar.arquivo_hd')->middleware('auth');

    // Rotas de exclusão dos arquivos
    Route::get('/excluir/arquivo-sd/{id}', 'TrechoController@excluirSD')->name('delete.arquivoSD')->middleware('auth');
    Route::get('/excluir/arquivo-hd/{id}', 'TrechoController@excluirHD')->name('delete.arquivoHD')->middleware('auth');
});