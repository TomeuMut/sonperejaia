<?php namespace Bmut\Headers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBmutHeadersSlides extends Migration
{
    public function up()
    {
        Schema::table('bmut_headers_slides', function($table)
        {
            $table->text('buttons')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('bmut_headers_slides', function($table)
        {
            $table->dropColumn('buttons');
        });
    }
}
