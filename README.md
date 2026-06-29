<<<<<<< HEAD
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
=======
# UltraMed Farma — Sistema de Gestão Farmacêutica

> Programação Web  
> Prof. Cristiano Garcia | IFSC — Caçador/SC  
> Aluno: Ramon Lodi de Sousa

---

## Sobre o sistema

A UltraMed Farma é um sistema web de e-commerce farmacêutico desenvolvido em Laravel, permitindo que clientes comprem remédios e produtos de perfumaria sem sair de casa. As entregas são gerenciadas pelo sistema de logística **CaçaLog** e os pagamentos processados pelo **CaçaPay**.

---

## Tecnologias utilizadas

- **PHP 8+** com **Laravel 11**
- **MySQL** (porta 3307)
- **Bootstrap 5** + Bootstrap Icons
- **Laravel HTTP Client** para integração com APIs externas

---

## Sistemas externos

O sistema depende de dois serviços externos rodando localmente:

| Sistema | Porta | Função |
|---|---|---|
| UltraMed | 8000 | Sistema de gerenciamento |
| CaçaPay | 8001 | Processamento de pagamentos |
| CaçaLog | 8002 | Logística e rastreamento de entregas |

---

## Usuários padrão

### Administrador
| Campo | Valor |
|---|---|
| E-mail | admin@farmacia.com |
| Senha | *(definida no seeder)* |
| Acesso | Painel admin completo |

### Cliente
| Campo | Valor |
|---|---|
| E-mail | *(cadastro pela tela de registro)* |
| Senha | *(definida no cadastro)* |
| Acesso | Loja, carrinho, pedidos e endereços |

---

## Funcionalidades

### Área do Cliente
- Cadastro e login
- Catálogo de produtos com filtro por categoria
- Carrinho de compras
- Pagamento integrado com CaçaPay
- Cadastro de múltiplos endereços de entrega
- Acompanhamento de pedidos em tempo real com timeline de status

### Área Administrativa
- Dashboard gerencial com gráficos (vendas, produtos, categorias)
- CRUD de produtos (com upload de até 5 fotos por produto)
- CRUD de categorias (com suporte a subcategorias)
- CRUD de fornecedores
- CRUD de promoções (por categoria, desconto percentual ou absoluto, com validade)
- CRUD de cidades e endereços
  
---

## Integrações

### CaçaPay
- **Endpoint:** `POST /api/compras`
- **Fluxo:** ao finalizar compra, o sistema consulta o CaçaPay com o CPF do cliente e o valor total. Se o cliente não existir, é criado com saldo promocional de R$ 50,00. Se existir com saldo suficiente, o valor é descontado. Caso contrário, a compra é negada.

### CaçaLog
- **Endpoint de envio:** `POST /api/entregas`
- **Fluxo:** após aprovação do pagamento, o sistema registra a entrega no CaçaLog com os dados do destinatário, endereço, CEP e conteúdo do pedido.
- **Webhook de retorno:** `POST /api/entrega/status`  
  O CaçaLog notifica o sistema via callback sempre que o status da entrega é atualizado. O sistema atualiza o campo `status_entrega` da venda automaticamente.

#### Status de entrega possíveis (enviados pelo CaçaLog)

| Status | Descrição |
|---|---|
| Pendente | Aguardando designação |
| Saiu para entrega | Designado a um motoboy |
| Em Trânsito | Em rota de entrega |
| Entregue | Entregue ao destinatário |
| Cancelado | Cancelado |
| Devolvido | Devolvido ao remetente |

---

## Requisitos implementados

### Parte 1
- [x] Cadastro de clientes
- [x] Cadastro de categorias (com subcategorias)
- [x] Cadastro de produtos (com slug, estoque, categoria)
- [x] Upload de fotos de produtos (máx. 5 por produto)
- [x] Cadastro de cidades
- [x] Cadastro de endereços
- [x] Cadastro de vendas
- [x] Cadastro de fornecedores
- [x] Cadastro de promoções
- [x] Middleware para controle de acesso (admin / cliente)
- [x] Sistema de login
- [x] Interface e-commerce com carrinho via session

### Parte 2
- [x] Dashboard gerencial com gráficos
- [x] Integração com CaçaPay (pagamento por CPF com validação de saldo)
- [x] Integração com CaçaLog (registro de entrega)
- [x] Webhook para receber atualizações de status do CaçaLog
- [x] Campo `status_entrega` na venda
- [x] Campo `status_pagamento` na venda
- [x] Tela de configuração (URLs e tokens no banco)
- [x] Monitoramento com Google Analytics
>>>>>>> b7118fb10404280617c5b3828a88172f069a6fb7
