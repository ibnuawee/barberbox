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
        Schema::table('top_ups', function (Blueprint $table) {
            //
            $table->string('invoice')->nullable()->after('id');
            $table->integer('admin_fee')->after('amount');
            $table->integer('total_amount')->after('admin_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('top_ups', function (Blueprint $table) {
            //
            $table->dropColumn(['invoice', 'admin_fee', 'total_amount']);
        });
    }
};
