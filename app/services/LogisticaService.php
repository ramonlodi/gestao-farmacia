<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LogisticaService
{
    public function registrarPedido(int $vendaId, string $enderecoFormatado): bool
    {
        $url = env('CACALOG_URL');
        $token = env('CACALOG_TOKEN');
        $callback = env('APP_URL') . '/api/entrega/status';

        try {
            $response = Http::withToken($token)
                ->post("{$url}/api/pedidos", [
                    'codigo_pedido'    => (string) $vendaId,
                    'endereco_entrega' => $enderecoFormatado,
                    'callback_url'     => $callback,
                ]);

            if ($response->successful()) {
                Log::info('Pedido registrado na logística', ['venda_id' => $vendaId]);
                return true;
            }

            Log::error('Erro ao registrar na logística', [
                'venda_id' => $vendaId,
                'status'   => $response->status(),
                'body'     => $response->body(),
            ]);
            return false;

        } catch (\Exception $e) {
            Log::error('Exceção ao registrar na logística', [
                'venda_id' => $vendaId,
                'erro'     => $e->getMessage(),
            ]);
            return false;
        }
    }
}