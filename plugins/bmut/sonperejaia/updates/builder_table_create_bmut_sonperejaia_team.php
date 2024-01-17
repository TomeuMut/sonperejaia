<?php namespace Bmut\SonPereJaia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBmutSonperejaiaTeam extends Migration
{
    public function up()
    {
        Schema::create('bmut_sonperejaia_team', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('position')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bmut_sonperejaia_team');
    }
}
