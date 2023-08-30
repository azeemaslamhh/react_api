<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('user_settings')) {
            Schema::create('user_settings', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->nullable();
                $table->integer('price_per_message')->nullable()->default(-1);
                $table->integer('free_credits')->nullable()->default(-1);
                $table->integer('daily_message_limit')->nullable()->default(-1);
                $table->integer('monthly_message_limit')->nullable()->default(-1);
                $table->integer('monthly_conversation_limit')->nullable()->default(-1);
                $table->boolean('delivery_notification')->nullable()->default(1);
                $table->boolean('read_notification')->nullable()->default(1);
                $table->boolean('web_hook')->nullable()->default(0);
                $table->boolean('automation_limit')->nullable()->default(1);
                $table->boolean('automation_action_limit')->nullable()->default(1);
                $table->boolean('segment_limit')->nullable()->default(1);
                $table->integer('sent_count')->nullable()->default(0);
                $table->integer('delivered_count')->nullable()->default(0);
                $table->integer('read_count')->nullable()->default(0);
                $table->integer('no_of_contacts_count')->nullable()->default(0);
                $table->float('balance', 10, 0)->nullable()->default(0);                
                $table->timestamp('created_at')->nullable()->useCurrent();
                $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            });
        }
        else{
            if (!Schema::hasColumn('user_settings', 'id')) {
                Schema::table('user_settings', function (Blueprint $table) {
                    $table->integer('id', true);
                });
            }
            if (!Schema::hasColumn('user_settings', 'user_id')) {
                Schema::table('user_settings', function (Blueprint $table) {
                    $table->integer('user_id')->nullable();
                });
            }
            if (!Schema::hasColumn('user_settings', 'price_per_message')) {
                Schema::table('user_settings', function (Blueprint $table) {
                    $table->float('price_per_message', 10, 0)->nullable()->default(0);    
                });
            }
            if (!Schema::hasColumn('user_settings', 'free_credits')) {
                Schema::table('user_settings', function (Blueprint $table) {
                    $table->integer('free_credits')->nullable();    
                });
            }
            if (!Schema::hasColumn('user_settings', 'daily_message_limit')) {
                Schema::table('user_settings', function (Blueprint $table) {
                     $table->integer('daily_message_limit')->nullable();  
                });
            }
            if (!Schema::hasColumn('user_settings', 'daily_conversation_limit')) {
                Schema::table('user_settings', function (Blueprint $table) {
                     $table->integer('daily_conversation_limit')->nullable(); 
                });
            }
            if (!Schema::hasColumn('user_settings', 'monthly_message_limit')) {
                Schema::table('user_settings', function (Blueprint $table) {
                     $table->integer('monthly_message_limit')->nullable();
                });
            }
            if (!Schema::hasColumn('user_settings', 'monthly_conversation_limit')) {
                Schema::table('user_settings', function (Blueprint $table) {
                     $table->integer('monthly_conversation_limit')->nullable();
                });
            }
            if (!Schema::hasColumn('user_settings', 'delivery_notification')) {
                Schema::table('user_settings', function (Blueprint $table) {
                     $table->boolean('delivery_notification')->nullable()->default(1);
                });
            }
            if (!Schema::hasColumn('user_settings', 'read_notification')) {
                Schema::table('user_settings', function (Blueprint $table) {
                     $table->boolean('read_notification')->nullable()->default(1);
                });
            }
            if (!Schema::hasColumn('user_settings', 'web_hook')) {
                Schema::table('user_settings', function (Blueprint $table) {
                     $table->boolean('web_hook')->nullable()->default(0);
                });
            }
            if (!Schema::hasColumn('user_settings', 'automation_limit')) {
                Schema::table('user_settings', function (Blueprint $table) {
                     $table->boolean('automation_limit')->nullable()->default(1);
                });
            }
            if (!Schema::hasColumn('user_settings', 'automation_action_limit')) {
                Schema::table('user_settings', function (Blueprint $table) {
                     $table->boolean('automation_action_limit')->nullable()->default(1);
                });
            }
            if (!Schema::hasColumn('user_settings', 'segment_limit')) {
                Schema::table('user_settings', function (Blueprint $table) {
                     $table->boolean('segment_limit')->nullable()->default(1);
                });
            }
            
            if (!Schema::hasColumn('user_settings', 'sent')) {
                Schema::table('user_settings', function (Blueprint $table) {
                     $table->integer('sent')->nullable()->default(0);
                });
            }
            if (!Schema::hasColumn('user_settings', 'delivered')) {
                Schema::table('user_settings', function (Blueprint $table) {
                     $table->integer('delivered')->nullable()->default(0);
                });
            }
            if (!Schema::hasColumn('user_settings', 'read')) {
                Schema::table('user_settings', function (Blueprint $table) {
                     $table->integer('read')->nullable()->default(0);
                });
            }
                
                
                $table->integer('no_of_contacts')->nullable()->default(0);
                $table->float('balance', 10, 0)->nullable()->default(0);                
                
                
            if (!Schema::hasColumn('user_settings', 'created_at')) {
                Schema::table('user_settings', function (Blueprint $table) {
                    $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
                });
            }
            if (!Schema::hasColumn('user_settings', 'updated_at')) {
                Schema::table('user_settings', function (Blueprint $table) {
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
        Schema::dropIfExists('user_settings');
    }
};
