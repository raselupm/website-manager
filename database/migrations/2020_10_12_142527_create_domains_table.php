<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->char('name', 200)->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('ssl');
            $table->unsignedBigInteger('force_hosting')->nullable();
            $table->char('cms', 15)->nullable();
            $table->decimal('cms_version', 3, 2)->nullable();
            $table->json('dns_data')->nullable();
            $table->json('whois_data')->nullable();

            $table->timestamps();
        });

        Schema::create('domain_event', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('domain_id');
            $table->unsignedBigInteger('event_id');

            $table->timestamps();

            $table->foreign('domain_id')->references('id')->on('domains');
            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domains');
    }
}
