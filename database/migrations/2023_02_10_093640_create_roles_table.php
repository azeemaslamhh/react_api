<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRolesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->integer('id', true);
                $table->string('role_name', 191)->nullable();
                $table->integer('user_id')->nullable();
                $table->boolean('is_deleted')->default(0);
                $table->timestamp('created_at')->nullable()->useCurrent();
                $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            });
            DB::table('roles')->insert([
                'id' => 1,
                'role_name' => "Super Administrator",
                'user_id' => 2,
                'is_deleted' => 0,
                'updated_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
            ]);
            DB::table('roles')->insert([
                'id' => 2,
                'role_name' => "Clients",
                'user_id' => 2,
                'is_deleted' => 0,
                'updated_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        } else {
            if (!Schema::hasColumn('roles', 'id')) {
                Schema::table('roles', function (Blueprint $table) {
                    $table->integer('id', true);
                });
            }
            if (!Schema::hasColumn('roles', 'role_name')) {
                Schema::table('roles', function (Blueprint $table) {
                     $table->string('role_name', 191)->nullable();
                });
            }
            if (!Schema::hasColumn('roles', 'user_id')) {
                Schema::table('roles', function (Blueprint $table) {
                     $table->string('user_id', 191)->nullable();
                });
            }
            if (!Schema::hasColumn('roles', 'user_id')) {
                Schema::table('roles', function (Blueprint $table) {
                     $table->boolean('is_deleted')->default(0);
                });
            }
                            
            if (!Schema::hasColumn('roles', 'created_at')) {
                Schema::table('roles', function (Blueprint $table) {
                    $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
                });
            }
            if (!Schema::hasColumn('roles', 'updated_at')) {
                Schema::table('roles', function (Blueprint $table) {
                    $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->nullable()->useCurrent();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('roles');
    }

}
