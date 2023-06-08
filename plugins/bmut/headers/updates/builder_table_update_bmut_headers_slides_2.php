<?php namespace Bmut\Headers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBmutHeadersSlides2 extends Migration
{
    public function up()
    {
        Schema::table('bmut_headers_slides', function($table)
        {
            $table->string('subtitle')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('bmut_headers_slides', function($table)
        {
            $table->dropColumn('subtitle');
        });
    }
}