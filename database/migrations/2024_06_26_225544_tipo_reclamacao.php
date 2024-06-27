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
        Schema::create('tipo_reclamacao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome')->unique();
            $table->timestamps();
        });

        // Populando a tabela com os valores iniciais
        DB::table('tipo_reclamacao')->insert([
            ['nome' => ''],
            ['nome' => 'dup'],
            ['nome' => 'rev'],
            ['nome' => 'reg']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
