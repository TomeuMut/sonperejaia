<?php


namespace Bmut\Utils\Updates;

use Bmut\Utils\Models\Settings;
use Schema;
use October\Rain\Database\Updates\Migration;

class richeditor_enabled_by_default extends Migration
{

    public function up()
    {
        $settings = Settings::instance();
        $settings->blog_richeditor = 1;
        $settings->save();
    }
}