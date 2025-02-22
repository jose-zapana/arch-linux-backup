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
    
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
                    
            $table->string('pdf_path')->nullable();
    
            $table->json('content');  // Mantener como JSON para almacenar el carrito
    
            // Cambiar address a address_id
            $table->foreignId('address_id')
                ->constrained('addresses')  // Relacionar con la tabla 'addresses'
                ->onDelete('cascade');      // Eliminar la orden si la dirección se elimina
    
            $table->integer('payment_method')->default(1);
            $table->string('payment_id');
    
            // Usar decimal para evitar problemas de precisión con dinero
            $table->decimal('total', 10, 2);  // 10 dígitos en total, 2 decimales
    
            $table->integer('status')->default(1);
    
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
