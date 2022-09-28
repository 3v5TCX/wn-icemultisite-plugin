<?php namespace IceCollection\Multisite\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;


class CreateSettingsTable extends Migration
{

    public function up()
    {
        Schema::create('icecollection_multisite_settings', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('domain');
            $table->text('theme');
            $table->boolean('is_protected')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('icecollection_multisite_settings');
    }

}
