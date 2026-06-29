<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venda;
use App\Models\User;
use App\Models\Produto;
use App\Models\Endereco;
use Carbon\Carbon;

class VendaSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $cliente = User::where('role', 'cliente')->first();

        if (!$cliente) {
            $cliente = User::create([
                'nome' => 'Cliente Teste',
                'cpf' => '111.111.111-11',
                'email' => 'cliente@teste.com',
                'password' => bcrypt('123456'),
                'role' => 'cliente',
            ]);
        }

        $endereco = Endereco::where('user_id', $cliente->id)->first();

        if (!$endereco) {
            $endereco = \App\Models\Cidade::first();
            if ($endereco) {
                $endereco = \App\Models\Endereco::create([
                    'user_id' => $cliente->id,
                    'descricao' => 'Casa',
                    'logradouro' => 'Rua Teste',
                    'numero' => '100',
                    'bairro' => 'Centro',
                    'cidade_id' => \App\Models\Cidade::first()->id,
                ]);
            }
        }

        $produtoIds = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 71];

        $dataInicio = Carbon::now()->subDays(30);

        for ($i = 0; $i < 60; $i++) {
            $dataVenda = $dataInicio->copy()->addDays(rand(0, 30))->addHours(rand(8, 20))->addMinutes(rand(0, 59));

            $produtos = Produto::whereIn('id', $produtoIds)->inRandomOrder()->take(rand(1, 4))->get();

            if ($produtos->isEmpty()) continue;

            $valorTotal = 0;
            $itens = [];

            foreach ($produtos as $produto) {
                $quantidade = rand(1, 3);
                $subtotal = $produto->valor * $quantidade;
                $valorTotal += $subtotal;
                $itens[] = [
                    'produto' => $produto,
                    'quantidade' => $quantidade,
                    'subtotal' => $subtotal,
                ];
            }

            $venda = Venda::create([
                'user_id' => $cliente->id,
                'endereco_id' => $endereco ? $endereco->id : null,
                'valor_total' => $valorTotal,
                'created_at' => $dataVenda,
                'updated_at' => $dataVenda,
            ]);

            foreach ($itens as $item) {
                $venda->produtos()->attach($item['produto']->id, [
                    'quantidade' => $item['quantidade'],
                    'subtotal' => $item['subtotal'],
                ]);
            }
        }

        $this->command->info('60 vendas criadas com sucesso!');
    }
}