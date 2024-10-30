<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateIntegrationLogsTable
 */
class CreateIntegrationLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integration_logs', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->timestamp('sync_period_from')->nullable();
            $table->timestamp('sync_period_to')->nullable();
            $table->integer('sync_offset')->nullable();
            $table->boolean('sync_status')->nullable();
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
        Schema::dropIfExists('integration_logs');
    }
}
