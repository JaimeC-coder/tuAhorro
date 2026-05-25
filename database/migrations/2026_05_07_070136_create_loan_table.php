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
        Schema::create('loan', function (Blueprint $table) {
            $table->id();
            $table->string('person');
            $table->decimal('amount', 15, 2);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type_loans', ['prestamo', 'cuota'])->default('prestamo');
            $table->enum('type', ['pendiente', 'pagado','prestamo'])->default('pendiente');
            $table->decimal('porcent', 5, 2)->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan');
    }
};
