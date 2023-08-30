<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        if (!Schema::hasTable('role_permissions')) {
            Schema::create('role_permissions', function (Blueprint $table) {
                $table->integer('id', true);
                $table->integer('role_id')->nullable();
                $table->integer('menu_id')->nullable();
                $table->timestamp('created_at')->nullable()->useCurrent();
                $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate()->useCurrent();
            });
        } else {
            if (!Schema::hasColumn('role_permissions', 'id')) {
                Schema::table('role_permissions', function (Blueprint $table) {
                    $table->integer('id', true);
                });
            }
            if (!Schema::hasColumn('role_permissions', 'role_id')) {
                Schema::table('role_permissions', function (Blueprint $table) {
                    $table->integer('role_id')->nullable();
                });
            }
            if (!Schema::hasColumn('role_permissions', 'menu_id')) {
                Schema::table('role_permissions', function (Blueprint $table) {
                    $table->integer('menu_id')->nullable();
                });
            }
            if (!Schema::hasColumn('role_permissions', 'created_at')) {
                Schema::table('role_permissions', function (Blueprint $table) {
                    $table->timestamp('created_at')->nullable()->useCurrent();
                });
            }
            if (!Schema::hasColumn('role_permissions', 'updated_at')) {
                Schema::table('role_permissions', function (Blueprint $table) {
                    $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate()->useCurrent();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('role_permissions');
    }
};
