<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusItemsTable extends Migration
{
    public function up()
    {
        Schema::create('bonus_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->string('item_type');
            $table->unsignedInteger('quantity')->default(1);
            $table->boolean('is_static')->default(true);
            $table->boolean('is_claimed')->default(false);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bonus_items');
    }
}
