<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ProdutoController;
use App\Http\Controllers\Admin\FornecedorController;
use App\Http\Controllers\Admin\CidadeController;
use App\Http\Controllers\Admin\PromocaoController;
use App\Http\Controllers\Cliente\EnderecoController;
use App\Http\Controllers\Cliente\VendaController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produto/{slug}', [HomeController::class, 'show'])->name('produto.show');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/registro', [AuthController::class, 'showRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registro']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [HomeController::class, 'adminPanel'])->name('dashboard');
    Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('dashboard.view');
    Route::resource('categorias', CategoriaController::class);
    Route::resource('produtos', ProdutoController::class);
    Route::delete('produtos/foto/{foto}', [ProdutoController::class, 'destroyFoto'])->name('produtos.foto.destroy');
    Route::resource('fornecedores', FornecedorController::class);
    Route::resource('cidades', CidadeController::class);
    Route::resource('promocoes', PromocaoController::class)->parameters(['promocoes' => 'promocao']);
});

Route::prefix('cliente')->name('cliente.')->middleware('cliente')->group(function () {
    Route::resource('enderecos', EnderecoController::class);
    Route::get('carrinho', [VendaController::class, 'carrinho'])->name('carrinho');
    Route::post('carrinho/adicionar', [VendaController::class, 'adicionar'])->name('carrinho.adicionar');
    Route::post('carrinho/remover', [VendaController::class, 'remover'])->name('carrinho.remover');
    Route::get('finalizar', [VendaController::class, 'finalizar'])->name('finalizar');
    Route::post('finalizar', [VendaController::class, 'store'])->name('venda.store');
    Route::get('pedidos', [VendaController::class, 'historico'])->name('pedidos');
});