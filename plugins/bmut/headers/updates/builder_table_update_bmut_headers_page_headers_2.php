<?php namespace Bmut\Headers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBmutHeadersPageHeaders2 extends Migration
{
    public function up()
    {
        Schema::table('bmut_headers_page_headers', function($table)
        {
            $table->boolean('is_video')->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('bmut_headers_page_headers', function($table)
        {
            $table->dropColumn('is_video');
        });
    }
}
