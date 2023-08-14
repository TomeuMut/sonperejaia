<?php namespace Bmut\Headers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBmutHeadersPageHeaders2 extends Migration
{
    public function up()
    {
        Schema::table('bmut_headers_page_headers', function($table)
        {
            $table->text('description')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('bmut_headers_page_headers', function($table)
        {
            $table->dropColumn('description');
        });
    }
}