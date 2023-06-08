<?php namespace Bmut\Utils\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBmutUtilsSeo2 extends Migration
{
    public function up()
    {
        Schema::table('bmut_utils_seo', function($table)
        {
            $table->text('structured_data')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('bmut_utils_seo', function($table)
        {
            $table->dropColumn('structured_data');
        });
    }
}
