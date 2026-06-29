<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EntregaController;

Route::post('/entrega/status', [EntregaController::class, 'atualizarStatus']);