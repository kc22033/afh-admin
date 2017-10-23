<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBreedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('breeds', function (Blueprint $table) 
        {
            //
            $table->increments('id');
            $table->integer('species_id')->unsigned();
            $table->string('name')->unique();
            $table->string('description_url');
        });

        Schema::table('breeds', function (Blueprint $table) 
        {
            $table->foreign('species_id')->references('id')->on('species');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::dropIfExists('breeds');
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}