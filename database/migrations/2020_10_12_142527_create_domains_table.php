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
            $table->char('name', 200);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('ssl');
            $table->unsignedBigInteger('force_hosting')->nullable();
            $table->char('cms', 15)->nullable();
            $table->decimal('cms_version', 3, 2)->nullable();
            $table->json('dns_data')->nullable();
            $table->json('whois_data')->nullable();

            $table->timestamps();
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
