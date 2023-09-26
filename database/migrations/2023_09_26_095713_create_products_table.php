<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->timestamps();
        });

             // Create two products
             DB::table('products')->insert([
                'id' => 1,
                'name' => 'Product 1',
                'price' => 10.99,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            DB::table('products')->insert([
                'id' => 2,
                'name' => 'Product 2',
                'price' => 19.99,
                'quantity' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
