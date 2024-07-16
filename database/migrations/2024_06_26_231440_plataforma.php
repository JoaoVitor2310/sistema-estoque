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
        Schema::create('plataforma', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome')->unique();
            $table->timestamps();
        });

        DB::table('plataforma')->insert([
            ['nome' => ''],
            ['nome' => 'G2A'],
            ['nome' => 'Gamivo'],
            ['nome' => 'Kinguin'],
            ['nome' => 'Eneba'],
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
