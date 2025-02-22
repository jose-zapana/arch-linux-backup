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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->datetime('start_at');
            $table->datetime('end_at')->nullable();
            $table->enum('payment_terms', ['7 DÍAS', '15 DÍAS', '30 DÍAS'])->nullable()->default('7 DÍAS');
            $table->enum('status', ['EN PROCESO', 'ENVIADO',  'APROBADO', 'RECHAZADO',  'EXPIRADO'])->default('EN PROCESO');
            $table->string('reference', 255)->nullable();
            $table->text('notes', 500)->nullable();
            $table->integer('discount')->nullable();
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(18);
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
