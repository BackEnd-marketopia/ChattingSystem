<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemStatusHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('item_status_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_package_id');
            $table->morphs('item'); // item_id + item_type
            $table->enum('status', ['pending', 'accepted', 'edited', 'declined']);
            $table->text('note')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('client_package_id')->references('id')->on('client_package')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_status_histories');
    }
}
