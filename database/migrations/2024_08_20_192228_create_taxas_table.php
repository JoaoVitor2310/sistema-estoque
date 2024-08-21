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
        Schema::create('taxas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->decimal('preco', total: 8, places: 3);
            $table->timestamps();
        });

        DB::table('taxas')->insert([
            ['nome' => 'gamivoPercentualMaior4', 'preco' => 0.079],
            ['nome' => 'gamivoFixoMaior4', 'precoEUR' => 0.35],
            
            ['nome' => 'gamivoPercentualMenor4', 'precoEUR' => 0.05],
            ['nome' => 'gamivoFixoMenor4', 'precoEUR' => 0.1],
            
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxas');
    }
};
