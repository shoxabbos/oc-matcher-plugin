<?php namespace Shohabbos\Matcher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateShohabbosMatcherLists extends Migration
{
    public function up()
    {
        Schema::create('shohabbos_matcher_lists', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('id');
            $table->integer('user_id');
            $table->integer('listable_id');
            $table->string('listable_type');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('shohabbos_matcher_lists');
    }
}
