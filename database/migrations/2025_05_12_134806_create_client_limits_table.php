<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientLimitsTable extends Migration
{
    public function up()
    {
        Schema::create('client_limits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->string('item_type');
            $table->unsignedInteger('max_edits_per_item')->default(0);
            $table->unsignedInteger('max_declines_per_item')->default(0);
            $table->unsignedInteger('max_edits_per_type')->default(0);
            $table->unsignedInteger('max_declines_per_type')->default(0);
            $table->unsignedInteger('max_edits_per_package')->default(0);
            $table->unsignedInteger('max_declines_per_package')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_limits');
    }
}
