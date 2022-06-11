<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 64)->unique('agent_name_UNIQUE');
            $table->string('address', 198)->nullable();
            $table->string('phone', 64)->nullable();
            $table->string('mobile', 64)->nullable()->unique('mobile_UNIQUE');
            $table->string('email', 64)->nullable()->unique('agent_email_UNIQUE');
            $table->integer('country_id')->nullable()->index('fk_agents_countries1_idx');
            $table->integer('fiba_licence')->nullable()->unique('agent_fiba_licence_UNIQUE');
            $table->integer('created_at');
            $table->integer('updated_at');
            $table->string('slug', 64)->unique('agent_slug_UNIQUE');
            $table->string('skype', 64)->nullable()->unique('skype_UNIQUE');
            $table->string('fiba_url', 198)->nullable()->unique('crawler_url_UNIQUE');
            $table->integer('agency_id')->nullable()->index('fk_agents_agencies1_idx');
            $table->string('realgm_url', 198)->nullable()->unique('realgm_url_UNIQUE');
            $table->integer('total_players')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agents');
    }
}
