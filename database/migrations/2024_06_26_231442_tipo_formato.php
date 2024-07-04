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
        Schema::create('tipo_formato', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome')->unique();
            $table->timestamps();
        });

        DB::table('tipo_formato')->insert([
            ['nome' => 'Revelead Key'],
            ['nome' => 'Download Page'],
            ['nome' => 'Giftlink'],
            ['nome' => 'Steam Gift'],
            ['nome' => 'Free'],
            ['nome' => 'Compra Direta'],
            ['nome' => 'Troca']
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
