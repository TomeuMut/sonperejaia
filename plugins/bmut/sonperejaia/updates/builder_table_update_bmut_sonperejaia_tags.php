<?php namespace Bmut\SonPereJaia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBmutSonperejaiaTags extends Migration
{
    public function up()
    {
        Schema::table('bmut_sonperejaia_tags', function($table)
        {
            $table->string('slug', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('bmut_sonperejaia_tags', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}
