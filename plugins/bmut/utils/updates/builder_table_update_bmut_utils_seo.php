<?php namespace Bmut\Utils\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBmutUtilsSeo extends Migration
{
    public function up()
    {
        Schema::table('bmut_utils_seo', function($table)
        {
            $table->string('robots')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('bmut_utils_seo', function($table)
        {
            $table->dropColumn('robots');
        });
    }
}