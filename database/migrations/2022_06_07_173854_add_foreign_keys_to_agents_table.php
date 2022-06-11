<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->foreign(['agency_id'], 'fk_agents_agencies1')->references(['id'])->on('agencies')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign(['country_id'], 'fk_agents_countries1')->references(['id'])->on('countries')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->dropForeign('fk_agents_agencies1');
            $table->dropForeign('fk_agents_countries1');
        });
    }
}
