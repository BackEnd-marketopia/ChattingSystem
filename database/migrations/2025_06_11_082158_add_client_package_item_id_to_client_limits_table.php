<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('client_limits', function (Blueprint $table) {
            $table->unsignedBigInteger('client_package_item_id')->after('client_package_id');
            $table->foreign('client_package_item_id')->references('id')->on('client_package_items')->onDelete('cascade');
            $table->unique(['client_id', 'client_package_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_limits', function (Blueprint $table) {
            $table->dropForeign(['client_package_item_id']);
            $table->dropUnique(['client_id', 'client_package_item_id']);
            $table->dropColumn('client_package_item_id');
        });
    }
};
