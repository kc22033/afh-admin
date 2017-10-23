<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('species');
            $table->string('pri_breed');
            $table->string('sec_breed')->nullable();
            $table->string('status');
            $table->integer('rescue_groups_id')->unsigned()->nullable();
            $table->integer('animal_rescue_num')->unsigned()->nullable();
            $table->boolean('mix')->default(true);
            $table->date('date_of_birth');
            $table->date('intake_date');
            $table->date('status_date');
            $table->string('sex');
            $table->string('origin')->nullable();
            $table->string('origin_id')->nullable();
            $table->boolean('is_va_releasing_agency')->default(false);
            $table->boolean('altered')->default(false);
            $table->integer('weight')->nullable();
            $table->string('name');
            $table->string('image_file')->nullable();
            $table->string('color')->nullable();
            $table->string('tagnum')->nullable();
            $table->string('foster')->nullable();
            $table->text('narrative');
            $table->timestamps();
        });

        // Schema::table('animals', function (Blueprint $table) 
        // {
        //     $table->foreign('species_id')->references('id')->on('species');
        //     $table->foreign('pri_breed_id')->references('id')->on('breeds');
        //     $table->foreign('sec_breed_id')->references('id')->on('breeds');
        //     $table->foreign('status_id')->references('id')->on('statuses');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::dropIfExists('animals');

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
