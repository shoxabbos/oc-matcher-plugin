<?php namespace Shohabbos\Matcher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateShohabbosMatcherProperties extends Migration
{
    public function up()
    {
        Schema::create('shohabbos_matcher_properties', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('key', 100);
            $table->text('value');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('shohabbos_matcher_properties');
    }
}
