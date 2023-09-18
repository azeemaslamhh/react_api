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


        if (!Schema::hasTable('menu_lists')) {
            Schema::create('menu_lists', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug');
                $table->unsignedBigInteger('menu_type_id');
                $table->unsignedBigInteger('user_id');
                $table->foreign('menu_type_id')
                    ->references('id')
                    ->on('menu_types')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_lists');
    }
};
