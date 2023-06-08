<?php namespace Bmut\Headers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBmutHeadersPageHeaders extends Migration
{
    public function up()
    {
        Schema::create('bmut_headers_page_headers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('page');
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bmut_headers_page_headers');
    }
}