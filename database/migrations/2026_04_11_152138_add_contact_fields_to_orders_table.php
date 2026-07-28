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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('pickup_contact')->nullable()->after('is_fragile');
            $table->string('pickup_phone')->nullable()->after('pickup_contact');
            $table->string('delivery_contact')->nullable()->after('delivery_address');
            $table->string('delivery_phone')->nullable()->after('delivery_contact');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['pickup_contact', 'pickup_phone', 'delivery_contact', 'delivery_phone']);
        });
    }
};
