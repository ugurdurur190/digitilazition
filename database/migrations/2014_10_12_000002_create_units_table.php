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
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unit');
        });

        DB::table('units')->insert([
            ['unit' => 'KVKK'],
            ['unit' => 'Hukuk'],
            ['unit' => 'Mali'],

            ['unit' => 'Finans'],
            ['unit' => 'İnsan Kaynakları'],
            ['unit' => 'İş Geliştirme'],
            ['unit' => 'Müşteri İlişkileri'],
            ['unit' => 'Lojistik Operasyon'],
            ['unit' => 'Pazarlama'],
            ['unit' => 'Prodüksiyon'],
            ['unit' => 'Startejik Planlama'],
            ['unit' => 'Tedarik'],
            ['unit' => 'Ürün Geliştirme'],
            ['unit' => 'Yurtdışı'],
            ['unit' => 'Yönetim'],
            ['unit' => 'İade'],
            ['unit' => 'Arge']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
};