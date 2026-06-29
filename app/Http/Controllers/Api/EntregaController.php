<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EntregaController extends Controller
{
    private const STATUS_VALIDOS = [
        'Pendente',
        'Saiu para entrega',
        'Em Trânsito',
        'Entregue',
        'Cancelado',
        'Devolvido',
    ];

    public function atualizarStatus(Request $request)
    {
        $request->validate([
            'codigo_pedido' => 'required',
            'status' => 'required|string',
        ]);

        Log::info('Webhook CaçaLog recebido', [
            'codigo_pedido' => $request->codigo_pedido,
            'status' => $request->status,
        ]);

        $venda = Venda::find($request->codigo_pedido);

        if (!$venda) {
            Log::error('Webhook: pedido não encontrado', ['codigo_pedido' => $request->codigo_pedido]);
            return response()->json(['success' => false, 'message' => 'Pedido não encontrado.'], 404);
        }

        $venda->update(['status_entrega' => $request->status]);

        Log::info('Status de entrega atualizado', [
            'venda_id'     => $venda->id,
            'status_salvo' => $request->status,
        ]);

        return response()->json(['success' => true, 'message' => 'Status atualizado.']);
    }
}