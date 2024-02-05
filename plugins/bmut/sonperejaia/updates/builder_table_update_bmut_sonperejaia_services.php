<?php namespace Bmut\SonPereJaia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBmutSonperejaiaServices extends Migration
{
    public function up()
    {
        Schema::table('bmut_sonperejaia_services', function($table)
        {
            $table->boolean('before_after')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('bmut_sonperejaia_services', function($table)
        {
            $table->dropColumn('before_after');
        });
    }
}
