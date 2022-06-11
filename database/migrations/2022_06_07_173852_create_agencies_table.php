<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agencies', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 128)->unique('name_UNIQUE');
            $table->string('website', 128)->nullable()->unique('website_UNIQUE');
            $table->string('slug', 128)->unique('slug_UNIQUE');
            $table->integer('created_at');
            $table->integer('updated_at');
            $table->integer('total_players')->default(0);
            $table->integer('total_agents')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agencies');
    }
}
