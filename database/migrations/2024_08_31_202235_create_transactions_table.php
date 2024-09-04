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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable();
            $table->foreignId('post_offering_id')->nullable();
            $table->foreignId('payment_id')->nullable();
            $table->foreignId('tranfer_id')->nullable();
            $table->foreignId('starting_balance_id')->nullable();
            $table->date('date');
            $table->double('amount', 10, 3);
            $table->string('check_number')->nullable();
            $table->foreignId('type_id')->nullable();
            $table->foreignId('account_id')->constrained('account_names')->onDelete('cascade');

            
            $table->string('payable_to')->nullable();
            $table->string('notes', 999)->nullable();
            $table->integer('transaction_status')->comment('1=post offering; 2=payment; 3=transter_in; 4=tranfer_out; 5=starting_balance');
            
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
