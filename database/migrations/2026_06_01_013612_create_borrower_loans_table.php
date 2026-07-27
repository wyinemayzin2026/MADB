<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrower_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrower_id')->constrained('borrowers')->onDelete('cascade');

            $table->string('occupation');
            $table->decimal('monthly_income', 15, 2);
            $table->text('workplace_address');
            $table->string('saving_account_number');

            $table->integer('acres');
            $table->enum('season_type', ['rainy', 'winter']);
            $table->string('loan_type');
            $table->decimal('loan_limit', 15, 2)->default(10.00);
            $table->decimal('rate', 5, 2)->default(5.00);
            $table->decimal('total_amount', 15, 2);
            $table->string('atone_none');
            $table->date('loan_start_date');
            $table->date('loan_end_date');

            $table->string('guarantor_name');

            $table->string('tax_form_image')->nullable();
            $table->string('household_chart_image')->nullable(); // အိမ်ထောင်စုဇယားပုံ
            $table->string('nrc_front_image')->nullable();       // မှတ်ပုံတင်အရှေ့
            $table->string('nrc_back_image')->nullable();        // မှတ်ပုံတင်အနောက်

            $table->string('status')->default('pending');
            $table->string('rejected_reason');
            $table->boolean('is_closed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrower_loans');
    }
};
