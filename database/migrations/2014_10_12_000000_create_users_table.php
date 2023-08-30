<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\UserSettings;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->integer('role_id')->nullable();
                $table->string('photo')->nullable();
                $table->string('password')->nullable();
                $table->string('mobile_no')->nullable();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();     
                $table->boolean('is_deleted')->default(0);           
                $table->rememberToken();
                $table->timestamps();
            });
        } else {
            if (!Schema::hasColumn('users', 'id')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->id();
                });
            }
            if (!Schema::hasColumn('users', 'name')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('name');
                });
            }
            if (!Schema::hasColumn('users', 'email')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('email')->unique();
                });
            }
            if (!Schema::hasColumn('users', 'role_id')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->integer('role_id')->nullable();
                });
            }
            
            if (!Schema::hasColumn('users', 'mobile_no')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('mobile_no')->nullable();
                });
            }
            if (!Schema::hasColumn('users', 'first_name')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('first_name')->nullable();
                });
            }
            if (!Schema::hasColumn('users', 'last_name')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('last_name')->nullable();
                });
            }
            
            if (!Schema::hasColumn('users', 'token')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('token')->nullable();
                });
            }
           
            if (!Schema::hasColumn('users', 'is_deleted')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->boolean('is_deleted')->default(0);
                });
            }
            if (!Schema::hasColumn('users', 'remember_token')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->rememberToken();
                });
            }
            if (!Schema::hasColumn('users', 'created_at')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
                });
            }
            if (!Schema::hasColumn('users', 'updated_at')) {
                Schema::table('users', function (Blueprint $table) {
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
        Schema::dropIfExists('users');
    }
};
