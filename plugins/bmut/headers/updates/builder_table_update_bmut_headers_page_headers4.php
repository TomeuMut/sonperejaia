<?php namespace Bmut\Headers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBmutHeadersPageHeaders4 extends Migration
{
    public function up()
    {
        Schema::table('bmut_headers_page_headers', function($table)
        {
            $table->text('buttons')->nullable()->change();
            $table->text('items')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('bmut_headers_page_headers', function($table)
        {
            $table->text('buttons')->nullable(false)->change();
            $table->text('items')->nullable(false)->change();
        });
    }
}