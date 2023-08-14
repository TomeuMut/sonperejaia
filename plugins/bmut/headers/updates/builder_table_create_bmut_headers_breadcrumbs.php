<?php namespace Bmut\Headers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBmutHeadersBreadcrumbs extends Migration
{
    public function up()
    {
        Schema::create('bmut_headers_breadcrumbs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('page');
            $table->integer('page_id')->unsigned()->nullable();
            $table->string('breadcrumb')->nullable();
            $table->string('type')->nullable();
            $table->string('dom_element')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bmut_headers_breadcrumbs');
    }
}