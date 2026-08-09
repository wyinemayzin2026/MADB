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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrower_loan_id')
                ->nullable()
                ->constrained('borrower_loans')
                ->onDelete('set null');

            $table->decimal('amount', 25, 2);
            $table->string('status')->default('pending')->index();

            $table->string('payment_method', 50)->index(); // KBZPay, WavePay, Cash, Bank Transfer
            $table->string('transaction_id')->nullable()->unique(); // Cash ပေးချေမှုများတွင် tx_id မရှိနိုင်၍ nullable ပြုလုပ်ထားပါသည်
            $table->string('payment_screenshot')->nullable(); // Slip ပြေစာပုံ

            // 4. ဘဏ် / Account အချက်အလက်များ
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payements');
    }
};
