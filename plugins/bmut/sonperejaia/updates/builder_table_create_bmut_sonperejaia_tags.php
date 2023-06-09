<?php namespace Bmut\SonPereJaia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBmutSonperejaiaTags extends Migration
{
    public function up()
    {
        Schema::create('bmut_sonperejaia_tags', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bmut_sonperejaia_tags');
    }
}
