<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('venda_chave_trocas', function (Blueprint $table) {
            $table->id();
            $table->integer('reclamacoesAnteriores')->default(0);
            
            $table->unsignedBigInteger('tipo_reclamacao_id');
            $table->foreign('tipo_reclamacao_id')->references('id')->on('tipo_reclamacao');
            
            $table->string('steamId');
            $table->string('tipo_formato_id');
            $table->foreign('tipo_formato_id')->references('id')->on('tipo_formato');
            
            $table->string('chaveRecebida');
            $table->string('nomeJogo');
            $table->decimal('precoJogo', total: 8, places: 2);
            $table->decimal('notaMetacritic', total: 5, places: 2);
            $table->boolean('isSteam');
            $table->string('randomClassificationG2A');
            $table->string('observacao');

            $table->string('id_leilao_G2A');
            $table->foreign('id_leilao_G2A')->references('id')->on('tipo_leilao');

            $table->string('id_leilao_gamivo');
            $table->foreign('id_leilao_gamivo')->references('id')->on('tipo_leilao');
            
            $table->string('id_leilao_kinguin');
            $table->foreign('id_leilao_kinguin')->references('id')->on('tipo_leilao');
            
            $table->string('plataforma');
            
            $table->decimal('precoCliente', total: 8, places: 2);
            $table->decimal('precoVenda', total: 8, places: 2);
            $table->decimal('incomeReal', total: 8, places: 2);
            $table->decimal('incomeSimulado', total: 8, places: 2);
            $table->string('chaveEntregue'); // Key enviada para troca
            $table->string('valorPagoTotal'); // Pode ser o jogo enviado ou o valor pago total
            $table->decimal('valorPagoIndividual', total: 8, places: 2);
            $table->boolean('vendido');
            $table->integer('leiloes');
            $table->integer('quantidade');
            $table->boolean('devolucoes');
            $table->decimal('lucro', total: 8, places: 2);
            $table->decimal('lucro%', total: 8, places: 2);
            $table->date('dataAdquirida');
            $table->date('dataVenda');
            $table->date('dataVendida');
            $table->string('perfilOrigem');
            $table->string('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venda_chave_trocas');
    }
};
