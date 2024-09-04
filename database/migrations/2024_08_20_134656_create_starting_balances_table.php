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
        Schema::create('starting_balances', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->double('amount', 10, 3);
            $table
                ->foreignId('account_id') // Foreign key for the creator
                ->constrained('account_names') // Assumes 'users' table and default 'id' column
                ->onDelete('cascade');
                $table
                    ->foreignId('created_by') // Foreign key for the creator
                    ->constrained('users') // Assumes 'users' table and default 'id' column
                    ->onDelete('cascade');
                $table
                    ->foreignId('updated_by') // Foreign key for the updater
                    ->nullable() // Allows NULL values
                    ->constrained('users') // Assumes 'users' table and default 'id' column
                    ->onDelete('set null');
                $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('starting_balances');
    }
};
