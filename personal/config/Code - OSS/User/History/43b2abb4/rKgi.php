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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Relación con el modelo User
            $table->foreignId('user_id')
                ->constrained()  // Asume que 'users' es el nombre de la tabla
                ->onDelete('cascade');

            // Ruta del archivo PDF, si corresponde
            $table->string('pdf_path')->nullable();

            // 'content' y 'address' como campos JSON
            $table->json('content');
            $table->json('address');

            // Método de pago, puedes considerar usar un enum o una tabla separada para los métodos
            $table->integer('payment_method')->default(1);  // Este campo podría ser mejor con un enum

            // ID de transacción de pago
            $table->string('payment_id');

            // Total de la orden, se recomienda usar 'decimal' en lugar de 'float' para evitar problemas de precisión
            $table->decimal('total', 10, 2); // Usamos 'decimal' para evitar problemas de precisión con dinero

            // Estado de la orden, el valor predeterminado podría ser 1 (pendiente, por ejemplo)
            $table->integer('status')->default(1);

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
