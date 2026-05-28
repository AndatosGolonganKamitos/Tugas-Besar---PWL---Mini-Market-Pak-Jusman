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
        Schema::table('products', function (Blueprint $table) {

            $table->string('barcode')->nullable();

            $table->foreignId('supplier_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            $table->integer('min_stock')->default(5);

            $table->string('unit')->default('pcs');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
