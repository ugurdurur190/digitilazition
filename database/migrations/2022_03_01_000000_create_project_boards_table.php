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
        Schema::create('project_boards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('board');
        });

        DB::table('project_boards')->insert([
            ['board' => 'todo'],
            ['board' => 'inprogres'],
            ['board' => 'done'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_boards');
    }
};