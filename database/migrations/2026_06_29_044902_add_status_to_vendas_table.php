<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendas', function (Blueprint $table) {
            $table->string('status_pagamento')->default('pendente')->after('valor_total');
            $table->string('status_entrega')->default('Pendente')->after('status_pagamento');
        });
    }

    public function down(): void
    {
        Schema::table('vendas', function (Blueprint $table) {
            $table->dropColumn(['status_pagamento', 'status_entrega']);
        });
    }
};