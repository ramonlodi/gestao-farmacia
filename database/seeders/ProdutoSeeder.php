<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\Cidade;
use App\Models\User;
use App\Models\Venda;
use App\Models\Endereco;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        // Categorias pai
        $pais = [
            'Medicamentos',
            'Vitaminas e Suplementos',
            'Perfumaria',
            'Higiene Pessoal',
            'Dermocosméticos',
            'Bebê e Mamãe',
        ];

        $catPai = [];
        foreach ($pais as $nome) {
            $cat = Categoria::firstOrCreate(['nome' => $nome], ['categoria_pai_id' => null]);
            $catPai[$nome] = $cat->id;
        }

        // Subcategorias
        $subcategorias = [
            'Analgésicos'         => 'Medicamentos',
            'Antibióticos'        => 'Medicamentos',
            'Antialérgicos'       => 'Medicamentos',
            'Digestivos'          => 'Medicamentos',
            'Vitaminas'           => 'Vitaminas e Suplementos',
            'Minerais'            => 'Vitaminas e Suplementos',
            'Fragrâncias Femininas' => 'Perfumaria',
            'Fragrâncias Masculinas' => 'Perfumaria',
            'Cabelos'             => 'Higiene Pessoal',
            'Bucal'               => 'Higiene Pessoal',
            'Proteção Solar'      => 'Dermocosméticos',
            'Hidratação'          => 'Dermocosméticos',
            'Cuidados do Bebê'    => 'Bebê e Mamãe',
            'Gestante'            => 'Bebê e Mamãe',
        ];

        $catSub = [];
        foreach ($subcategorias as $nome => $pai) {
            $cat = Categoria::firstOrCreate(
                ['nome' => $nome],
                ['categoria_pai_id' => $catPai[$pai]]
            );
            $catSub[$nome] = $cat->id;
        }

        // Fornecedores
        $fornecedoresDados = [
            ['razao_social' => 'EMS Distribuidora Ltda',  'cnpj' => '11.111.111/0001-11', 'contato' => 'Carlos Lima',    'email' => 'contato@ems.com.br',        'telefone' => '(11) 91111-1111'],
            ['razao_social' => 'Eurofarma Ltda',           'cnpj' => '22.222.222/0001-22', 'contato' => 'Ana Paula',      'email' => 'contato@eurofarma.com.br',   'telefone' => '(11) 92222-2222'],
            ['razao_social' => 'Hypermarcas SA',           'cnpj' => '33.333.333/0001-33', 'contato' => 'Roberto Silva',  'email' => 'contato@hypermarcas.com.br', 'telefone' => '(11) 93333-3333'],
        ];

        $fornIds = [];
        foreach ($fornecedoresDados as $dados) {
            $f = Fornecedor::firstOrCreate(['cnpj' => $dados['cnpj']], $dados);
            $fornIds[] = $f->id;
        }

        // Cidades
        $cidades = [
            ['nome' => 'Caçador',      'estado' => 'SC'],
            ['nome' => 'Rio das Antas', 'estado' => 'SC'],
            ['nome' => 'Lebon Régis',  'estado' => 'SC'],
            ['nome' => 'Videira',      'estado' => 'SC'],
            ['nome' => 'Fraiburgo',    'estado' => 'SC'],
        ];

        foreach ($cidades as $dados) {
            Cidade::firstOrCreate(['nome' => $dados['nome'], 'estado' => $dados['estado']]);
        }

        // Produtos: [nome, descricao, estoque, valor, subcategoria, popularidade 1-5]
        $produtos = [
            // Analgésicos
            ['Paracetamol 500mg',      'Analgésico e antitérmico. Indicado para dores leves a moderadas e febre.',          150, 8.90,  'Analgésicos', 5],
            ['Ibuprofeno 600mg',       'Anti-inflamatório, analgésico e antitérmico. Ação rápida.',                         120, 14.50, 'Analgésicos', 4],
            ['Dipirona 1g',            'Analgésico e antitérmico de amplo uso e ação rápida.',                              200, 7.20,  'Analgésicos', 5],
            ['Nimesulida 100mg',       'Anti-inflamatório indicado para dores agudas e febre.',                              90, 16.80, 'Analgésicos', 3],
            ['Aspirina 500mg',         'Analgésico, antitérmico e anti-inflamatório clássico.',                             110, 11.90, 'Analgésicos', 3],

            // Antibióticos
            ['Amoxicilina 500mg',      'Antibiótico de amplo espectro. Uso sob prescrição médica.',                          80, 22.90, 'Antibióticos', 2],
            ['Azitromicina 500mg',     'Antibiótico indicado para infecções respiratórias. Prescrição obrigatória.',          60, 38.50, 'Antibióticos', 2],
            ['Cefalexina 500mg',       'Antibiótico cefalosporínico para infecções de pele e vias urinárias.',               55, 29.90, 'Antibióticos', 1],

            // Antialérgicos
            ['Loratadina 10mg',        'Antialérgico não sedativo. Indicado para rinite e urticária.',                       90, 12.80, 'Antialérgicos', 4],
            ['Cetirizina 10mg',        'Antialérgico de segunda geração. Eficaz contra rinite e coceira.',                   85, 14.90, 'Antialérgicos', 3],
            ['Desloratadina 5mg',      'Antialérgico de longa duração. Não causa sonolência.',                               70, 18.50, 'Antialérgicos', 2],

            // Digestivos
            ['Omeprazol 20mg',         'Inibidor da bomba de prótons. Indicado para gastrite e refluxo.',                   100, 18.50, 'Digestivos', 4],
            ['Pantoprazol 40mg',       'Protetor gástrico de alta potência. Indicado para úlceras.',                         75, 24.90, 'Digestivos', 3],
            ['Buscopan Composto',       'Antiespasmódico e analgésico para cólicas abdominais.',                             95, 21.90, 'Digestivos', 4],
            ['Probiótico Lactobacilos', 'Suplemento probiótico para equilíbrio da flora intestinal.',                        60, 44.90, 'Digestivos', 2],

            // Vitaminas
            ['Vitamina C 1g Efervescente', 'Suplemento de vitamina C. Auxilia na imunidade e disposição.',                 180, 19.90, 'Vitaminas', 5],
            ['Vitamina D3 2000UI',      'Suplemento de vitamina D. Essencial para ossos e imunidade.',                     140, 34.90, 'Vitaminas', 4],
            ['Vitamina E 400UI',        'Antioxidante natural. Protege as células do estresse oxidativo.',                   80, 28.90, 'Vitaminas', 2],
            ['Complexo B',              'Suplemento com vitaminas do complexo B. Auxilia no metabolismo energético.',       130, 24.50, 'Vitaminas', 3],
            ['Vitamina A 10000UI',      'Essencial para visão, imunidade e saúde da pele.',                                  65, 22.90, 'Vitaminas', 2],

            // Minerais
            ['Ômega 3 1g',             'Suplemento de ácidos graxos essenciais. Beneficia o coração e o cérebro.',         110, 42.00, 'Minerais', 3],
            ['Magnésio Quelato 400mg', 'Suplemento de magnésio de alta absorção. Reduz câimbras e fadiga.',                  90, 49.90, 'Minerais', 3],
            ['Cálcio + Vitamina D',    'Suplemento para saúde óssea. Formulação combinada de alta biodisponibilidade.',      75, 38.90, 'Minerais', 2],
            ['Ferro Bisglicinato 25mg','Suplemento de ferro quelato. Indicado para anemia ferropriva.',                      70, 32.90, 'Minerais', 2],
            ['Zinco 30mg',             'Mineral essencial para imunidade, cicatrização e fertilidade.',                      85, 26.50, 'Minerais', 2],

            // Fragrâncias Femininas
            ['Perfume Floral 75ml',    'Fragrância floral e frutada com notas de rosa e jasmim. Longa duração.',            40, 89.90, 'Fragrâncias Femininas', 3],
            ['Eau de Parfum Feminino', 'Perfume sofisticado com notas amadeiradas e florais. Alta concentração.',            30, 129.90,'Fragrâncias Femininas', 2],
            ['Colônia Feminina 100ml', 'Fragrância leve e fresca para o dia a dia. Notas cítricas e florais.',              50, 49.90, 'Fragrâncias Femininas', 3],

            // Fragrâncias Masculinas
            ['Perfume Masculino 100ml','Fragrância amadeirada e fresca. Ideal para o dia a dia.',                           35, 99.90, 'Fragrâncias Masculinas', 3],
            ['Eau de Toilette Masculino','Perfume vibrante com notas cítricas e especiadas.',                               28, 89.90, 'Fragrâncias Masculinas', 2],
            ['Desodorante Colônia 150ml','Desodorante colônia masculino de longa duração.',                                 60, 39.90, 'Fragrâncias Masculinas', 3],

            // Cabelos
            ['Shampoo Anticaspa 200ml','Controla a caspa e alivia a coceira no couro cabeludo.',                            85, 21.90, 'Cabelos', 4],
            ['Condicionador Hidratante','Condicionador nutritivo para cabelos secos e danificados.',                         80, 19.90, 'Cabelos', 3],
            ['Shampoo Neutro 200ml',   'Shampoo suave para uso diário. Indicado para cabelos normais.',                     90, 16.90, 'Cabelos', 3],

            // Bucal
            ['Escova Dental Macia',    'Escova de cerdas macias. Ideal para gengivas sensíveis.',                          200, 9.90,  'Bucal', 4],
            ['Creme Dental Branqueador','Creme dental com flúor e agente branqueador. Protege o esmalte.',                  150, 12.90, 'Bucal', 4],
            ['Fio Dental 50m',         'Fio dental encerado com sabor menta. Remove placa e resíduos.',                    180, 6.50,  'Bucal', 4],
            ['Enxaguante Bucal 500ml', 'Enxaguante bucal com flúor e antibacteriano. Hálito fresco por 12 horas.',         120, 18.90, 'Bucal', 3],

            // Proteção Solar
            ['Protetor Solar FPS 50',  'Proteção solar de alto espectro. Fórmula leve e não oleosa.',                       75, 48.90, 'Proteção Solar', 4],
            ['Protetor Solar FPS 30',  'Proteção solar diária. Textura fluida de fácil absorção.',                          80, 38.90, 'Proteção Solar', 3],
            ['Protetor Labial FPS 15', 'Protetor labial hidratante com filtro solar. Sabor neutro.',                       100, 14.90, 'Proteção Solar', 3],

            // Hidratação
            ['Hidratante Corporal 400ml','Creme hidratante de uso diário. Pele macia por até 24 horas.',                   60, 32.00, 'Hidratação', 3],
            ['Creme para Mãos 50ml',   'Hidratante intensivo para mãos. Absorção rápida e toque seco.',                    90, 16.90, 'Hidratação', 3],
            ['Gel Hidratante Facial',  'Hidratante facial oil-free. Indicado para peles mistas e oleosas.',                 55, 54.90, 'Hidratação', 2],

            // Cuidados do Bebê
            ['Pomada Assadura 45g',    'Previne e trata assaduras. Fórmula com óxido de zinco.',                           90, 16.90, 'Cuidados do Bebê', 3],
            ['Colônia Infantil 100ml', 'Fragrância suave e delicada para bebês e crianças.',                               55, 29.90, 'Cuidados do Bebê', 3],
            ['Shampoo Bebê 200ml',     'Shampoo suave com fórmula hipoalergênica. Não irrita os olhos.',                   70, 22.90, 'Cuidados do Bebê', 2],
            ['Lenço Umedecido 50un',   'Lenços umedecidos com aloe vera. Sem álcool e sem perfume.',                      100, 18.90, 'Cuidados do Bebê', 3],

            // Gestante
            ['Ácido Fólico 400mcg',    'Suplemento essencial no pré-natal. Reduz o risco de malformações.',                80, 19.90, 'Gestante', 2],
            ['Ferro Gestante 40mg',    'Suplemento de ferro para gestantes. Previne anemia gestacional.',                   65, 28.90, 'Gestante', 2],

            // Extra
            ['Termômetro Digital',     'Termômetro clínico digital com leitura rápida em 60 segundos.',                    50, 38.90, 'Analgésicos', 3],
        ];

        $produtosMap = [];

        foreach ($produtos as $dados) {
            [$nome, $descricao, $estoque, $valor, $subcat, $popularidade] = $dados;

            $slug = Str::slug($nome);
            $slugOriginal = $slug;
            $contador = 1;
            while (Produto::where('slug', $slug)->exists()) {
                $slug = $slugOriginal . '-' . $contador++;
            }

            $produto = Produto::firstOrCreate(
                ['slug' => $slug],
                [
                    'nome' => $nome,
                    'descricao' => $descricao,
                    'estoque' => $estoque,
                    'valor' => $valor,
                    'categoria_id' => $catSub[$subcat],
                    'slug' => $slug,
                ]
            );

            $produto->fornecedores()->syncWithoutDetaching(
                [$fornIds[array_rand($fornIds)]]
            );

            $produtosMap[] = ['produto' => $produto, 'popularidade' => $popularidade];
        }

        // Clientes de teste
        $clientesDados = [
            ['nome' => 'Maria Silva',    'cpf' => '111.111.111-11', 'email' => 'maria@teste.com'],
            ['nome' => 'João Souza',     'cpf' => '222.222.222-22', 'email' => 'joao@teste.com'],
            ['nome' => 'Ana Costa',      'cpf' => '333.333.333-33', 'email' => 'ana@teste.com'],
            ['nome' => 'Pedro Martins',  'cpf' => '444.444.444-44', 'email' => 'pedro@teste.com'],
            ['nome' => 'Lucia Ferreira', 'cpf' => '555.555.555-55', 'email' => 'lucia@teste.com'],
        ];

        $clientes = [];
        foreach ($clientesDados as $dados) {
            $cliente = User::firstOrCreate(
                ['email' => $dados['email']],
                [
                    'nome' => $dados['nome'],
                    'cpf' => $dados['cpf'],
                    'password' => Hash::make('123456'),
                    'role' => 'cliente',
                ]
            );
            $clientes[] = $cliente;
        }

        // Endereços dos clientes
        $cidadesIds = Cidade::pluck('id')->toArray();

        foreach ($clientes as $cliente) {
            if ($cliente->enderecos()->count() === 0) {
                Endereco::create([
                    'user_id' => $cliente->id,
                    'descricao' => 'Casa',
                    'logradouro' => 'Rua das Flores',
                    'numero' => rand(10, 999),
                    'bairro' => 'Centro',
                    'cidade_id' => $cidadesIds[array_rand($cidadesIds)],
                ]);
            }
        }

        // Vendas simuladas baseadas na popularidade
        foreach ($clientes as $cliente) {
            $endereco = $cliente->enderecos()->first();
            $numVendas = rand(2, 5);

            for ($v = 0; $v < $numVendas; $v++) {
                // Seleciona produtos com peso pela popularidade
                $selecionados = [];
                $pool = [];

                foreach ($produtosMap as $item) {
                    for ($p = 0; $p < $item['popularidade']; $p++) {
                        $pool[] = $item['produto'];
                    }
                }

                shuffle($pool);
                $qtdItens = rand(1, 4);
                $vistos = [];

                foreach ($pool as $prod) {
                    if (count($selecionados) >= $qtdItens) break;
                    if (in_array($prod->id, $vistos)) continue;
                    $vistos[] = $prod->id;
                    $selecionados[] = $prod;
                }

                if (empty($selecionados)) continue;

                $total = 0;
                $itens = [];

                foreach ($selecionados as $prod) {
                    $qtd = rand(1, 3);
                    $subtotal = round($prod->valor * $qtd, 2);
                    $total += $subtotal;
                    $itens[] = ['produto' => $prod, 'qtd' => $qtd, 'subtotal' => $subtotal];
                }

                $venda = Venda::create([
                    'user_id' => $cliente->id,
                    'endereco_id' => $endereco->id,
                    'valor_total' => round($total, 2),
                ]);

                foreach ($itens as $item) {
                    $venda->produtos()->attach($item['produto']->id, [
                        'quantidade' => $item['qtd'],
                        'subtotal' => $item['subtotal'],
                    ]);
                }
            }
        }
    }
}