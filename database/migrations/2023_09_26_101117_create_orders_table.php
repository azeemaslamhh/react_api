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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->string('address');
            $table->string('mobile');
            $table->date('delivered_date');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        DB::table('orders')->insert([
            'id' => 1,
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 3,
            'address' => '123 Main St',
            'mobile' => '123-456-7890',
            'delivered_date' => '2023-09-30',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('orders')->insert([
            'id' => 2,
            'user_id' => 1,
            'product_id' => 2,
            'quantity' => 2,
            'address' => '456 Elm St',
            'mobile' => '987-654-3210',
            'delivered_date' => '2023-09-28',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
