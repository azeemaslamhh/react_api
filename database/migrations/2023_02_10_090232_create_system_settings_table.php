<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSystemSettingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('application_settings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('setting_name', 191);
            $table->text('setting_value')->nullable();
        });

        $prefix = DB::getTablePrefix();
        $tableName = $prefix . 'application_settings';
        DB::statement("INSERT INTO ".$tableName." (`id`, `setting_name`, `setting_value`) VALUES
(1, 'validation_status', '1'),
(2, 'installation_domain', 'http://localhost:8000/'),
(3, 'log_retention_limit', '15'),
(4, 'from_name', 'Azeem'),
(5, 'from_email', 'm.azeem@hostingshouse.com'),
(6, 'export_batch_size', '40'),
(7, 'smtp_host', 'smtp.mumara.com'),
(8, 'smtp_username', 'V2FzaWZBaG1hZC05OC0zLXBvb2wtMjAzOC1TTVRQLTE2MjYzNTU0NDgtMTAx'),
(9, 'smtp_password', '60f036f84791e1626355448'),
(10, 'smtp_port', '587'),
(11, 'on_failed_credit_deduction', 'on'),
(12, 'record_batch_size', '500'),
(13, 'encryption_method', 'TLS'),
(14, 'server_ip', '182.180.148.77'),
(15, 'delete_trash_after', '0'),
(16, 'currency', '1'),
(17, 'starting_week', 'Monday'),
(18, 'credit_term', 'Cr'),
(19, 'client_auto_approved', 'off'),
(20, 'general_cron_time', '5'),
(21, 'time_zone', '+05:00'),
(22, 'send_a_broadcast_sms_zone', 'on'),
(23, 'free_balance', '2'),
(24, 'resend_email_count', '5'),
(25, 'whmcs_integration', 'off'),
(26, 'email_verification', 'off'),
(27, 'whmcs_url', 'http://billing-dev-jt.mumara.com/'),
(28, 'whmcs_auth_key', NULL),
(29, 'whmcs_identifier_key', 'hKZUPkOhygNZNox90yZRn72tT3rYitnC'),
(30, 'whmcs_secret_key', 'E689OgNIBlEYs7033mMF1RJcir6wF54A'),
(31, 'whmcs_api_link', NULL),
(32, 'whmch_server_id', NULL),
(33, 'admin_email_notification', 'on'),
(34, 'admin_sms_notification', 'on'),
(35, 'client_low_balance_notification_amount', '2'),
(36, 'whmcs_attributes', NULL),
(37, 'smtp_email', 'on'),
(38, 'email_global_header', 'Header'),
(39, 'email_global_footer', 'Footer'),
(40, 'application_title', 'MumaraSMS1'),
(41, 'copy_right_statement', 'Hostings House1'),
(42, 'tag_line', 'MumaraSMS Application'),
(43, 'maximum_threads', '1'),
(44, 'unsubscription_link', 'off'),
(45, 'token_expire', '-1'),
(46, 'whmcs_ip_address', '182.180.148.77');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('system_settings');
    }

}
