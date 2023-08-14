<?php namespace Bmut\Utils\Updates;

use Bmut\Utils\Models\Settings;
use Schema;
use October\Rain\Database\Updates\Migration;

class Migration1011 extends Migration
{
    public function up()
    {
        $settings = Settings::instance();
        $settings->detect_browser_language = 1;
        $settings->prefer_user_session = 1;
        $settings->save();
    }

    public function down()
    {
        // Schema::drop('bmut_utils_table');
    }
}