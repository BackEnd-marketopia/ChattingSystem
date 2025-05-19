<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageAllowedItemsTable extends Migration
{
    public function up()
    {
        Schema::create('package_allowed_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('package_item_id');
            $table->unsignedInteger('allowed_count')->default(0);

            $table->timestamps();

            $table->foreign('package_item_id')->references('id')->on('package_items')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('package_allowed_items');
    }
}
