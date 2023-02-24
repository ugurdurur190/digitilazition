<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privilege', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role');
        });

        DB::table('privilege')->insert([
            ['role' => 'Admin'],
            ['role' => 'Staff'],
            ['role' => 'Executive'],
            ['role' => 'Unit Executive'],
            ['role' => 'Developer'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('privilege');
    }
};