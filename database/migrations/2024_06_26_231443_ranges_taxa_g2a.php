<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ranges_taxa_g2a', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('minimo', total: 5, places: 2);
            $table->decimal('maximo', total: 5, places: 2);
            $table->decimal('taxa', total: 5, places: 2);
            $table->timestamps();
        });

        DB::table('tipo_formato')->insert([
            ['minimo' => 0, 'maximo' => 0.99, 'taxa' => 0.23],
            ['minimo' => 1, 'maximo' => 2.99, 'taxa' => 0.3],
            ['minimo' => 3, 'maximo' => 3.99, 'taxa' => 0.2775],
            ['minimo' => 4, 'maximo' => 6.99, 'taxa' => 0.255],
            ['minimo' => 7, 'maximo' => 7.99, 'taxa' => 0.243],
            ['minimo' => 8, 'maximo' => 8.99, 'taxa' => 0.2315],
            ['minimo' => 9, 'maximo' => 10.49, 'taxa' => 0.2085],
            ['minimo' => 10.5, 'maximo' => 10.99, 'taxa' => 0.197],
            ['minimo' => 10.5, 'maximo' => 10.99, 'taxa' => 0.197], // PArou aqui
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
