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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_available')->default(true)->after('phone')
                  ->comment('Agent duty toggle: on/off duty status');
            $table->string('status')->default('active')->after('is_available')
                  ->comment('Account status: active, suspended, banned');
            $table->decimal('performance_score', 3, 2)->default(0)->after('status')
                  ->comment('Performance score from 0.00 to 9.99');
            $table->json('delivery_addresses')->nullable()->after('performance_score')
                  ->comment('Saved delivery addresses for customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_available', 'status', 'performance_score', 'delivery_addresses']);
        });
    }
};
