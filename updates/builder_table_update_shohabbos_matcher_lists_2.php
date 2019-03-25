<?php namespace Shohabbos\Matcher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosMatcherLists2 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_matcher_lists', function($table)
        {
            $table->integer('id')->unsigned()->change();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_matcher_lists', function($table)
        {
            $table->integer('id')->unsigned(false)->change();
        });
    }
}
