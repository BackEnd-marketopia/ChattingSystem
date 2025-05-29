<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientPackageItemsTable extends Migration
{
    public function up()
    {
        Schema::create('client_package_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_package_id')->references('id')->on('client_package')->onDelete('cascade');

            $table->string('item_type');
            $table->unsignedBigInteger('package_item_id')->nullable();
            $table->foreign('package_item_id')->references('id')->on('package_items')->onDelete('set null');

            $table->text('content')->nullable();
            $table->string('media_url')->nullable();
            $table->enum('status', ['pending', 'accepted', 'declined', 'edited'])->default('pending');
            $table->text('client_note')->nullable();
            $table->unsignedBigInteger('handled_by')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_package_items');
    }
}
