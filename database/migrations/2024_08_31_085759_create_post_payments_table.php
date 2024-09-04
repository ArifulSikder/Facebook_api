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
        Schema::create('post_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_account')->constrained('account_names')->onDelete('cascade');
            $table->foreignId('to_account')->constrained('account_names')->onDelete('cascade');
            $table->date('date');
            $table->double('amount', 10, 3);
            $table->string('notes', 999);
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
        Schema::dropIfExists('post_payments');
    }
};
