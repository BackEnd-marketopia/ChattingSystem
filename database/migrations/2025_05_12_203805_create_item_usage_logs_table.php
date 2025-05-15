<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemUsageLogsTable extends Migration
{
    public function up()
    {
        Schema::create('item_usage_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_package_id');
            $table->morphs('item'); // item_id + item_type
            $table->enum('action', ['edit', 'accept', 'decline']);
            $table->text('note')->nullable();
            $table->unsignedBigInteger('performed_by')->nullable(); // user who did the action
            $table->timestamps();

            $table->foreign('client_package_id')->references('id')->on('client_package')->onDelete('cascade');
            $table->foreign('performed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_usage_logs');
    }
}
