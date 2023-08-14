<?php namespace Bmut\SonPereJaia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBmutSonperejaiaGallery extends Migration
{
    public function up()
    {
        Schema::rename('bmut_sonperejaia_', 'bmut_sonperejaia_gallery');
    }
    
    public function down()
    {
        Schema::rename('bmut_sonperejaia_gallery', 'bmut_sonperejaia_');
    }
}
