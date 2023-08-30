<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('permissions')) {
        Schema::create('permissions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('parent_id')->nullable();
            $table->string('default_title')->nullable();
            $table->integer('sequence')->default(0);
            $table->enum('route_type', ['web', 'api'])->default('web');
            $table->text('route')->nullable();
            $table->boolean('skip_in_menu')->nullable()->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
        }else{
            if (!Schema::hasColumn('permissions', 'id')) {
                Schema::table('permissions', function (Blueprint $table) {
                   $table->integer('id', true);
                });
            }
            if (!Schema::hasColumn('permissions', 'parent_id')) {
                Schema::table('permissions', function (Blueprint $table) {
                   $table->integer('parent_id')->nullable();
                });
            }
            if (!Schema::hasColumn('permissions', 'default_title')) {
                Schema::table('permissions', function (Blueprint $table) {
                   $table->string('default_title')->nullable();
                });
            }
            if (!Schema::hasColumn('permissions', 'sequence')) {
                Schema::table('permissions', function (Blueprint $table) {
                   $table->integer('sequence')->default(0);
                });
            }
            if (!Schema::hasColumn('permissions', 'route_type')) {
                Schema::table('permissions', function (Blueprint $table) {
                   $table->enum('route_type', ['web', 'api'])->default('web');
                });
            }
            if (!Schema::hasColumn('permissions', 'skip_in_menu')) {
                Schema::table('permissions', function (Blueprint $table) {
                  $table->boolean('skip_in_menu')->nullable()->default(0);
                });
            }            
            if (!Schema::hasColumn('permissions', 'created_at')) {
                Schema::table('permissions', function (Blueprint $table) {
                   $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
                });
            }
            if (!Schema::hasColumn('permissions', 'updated_at')) {
                Schema::table('permissions', function (Blueprint $table) {
                   $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->nullable()->useCurrent();
                });
            }
        }
        /*
        $prefix = DB::getTablePrefix();
        $tableName = $prefix . 'admin_role_rights';
        DB::statement("");
        */

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
