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
        Schema::create('loan_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('loan_id')->constrained('loan')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->enum('type', ['adelanto', 'prestamo', 'cuota']);
            $table->date('date');
            $table->string('description')->nullable();
            $table->enum('status', ['pendiente', 'pagado'])->default('pendiente');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_details');
    }
};
