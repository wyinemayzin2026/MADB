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
        Schema::table('borrower_loans', function (Blueprint $table) {
            $table->enum('repayment_type', ['online', 'outside'])
                ->default('online')
                ->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrower_loans', function (Blueprint $table) {
            $table->dropColumn('repayment_type');
        });
    }
};
