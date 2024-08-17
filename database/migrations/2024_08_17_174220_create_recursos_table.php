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
        Schema::create('recursos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->decimal('precoEUR', total: 8, places: 2);
            $table->decimal('preco$', total: 8, places: 2);
            $table->decimal('precoR$', total: 8, places: 2);
            $table->timestamps();
        });

        DB::table('recursos')->insert([
            ['nome' => 'TF2', 'precoEUR' => 1.37, 'preco$' => 8.23, 'precoR$' => 8.24],
            ['nome' => 'Gema', 'precoEUR' => 1.37, 'preco$' => 8.23, 'precoR$' => 8.24],
            ['nome' => 'ToD', 'precoEUR' => 1.37, 'preco$' => 8.23, 'precoR$' => 8.24],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recursos');
    }

};
