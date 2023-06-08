<?php namespace Bmut\Headers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBmutHeadersPageHeaders extends Migration
{
    public function up()
    {
        Schema::table('bmut_headers_page_headers', function($table)
        {
            $table->string('section_title')->nullable();
            $table->string('section_subtitle')->nullable();
            $table->text('section_description')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('bmut_headers_page_headers', function($table)
        {
            $table->dropColumn('section_title');
            $table->dropColumn('section_subtitle');
            $table->dropColumn('section_description');
        });
    }
}
