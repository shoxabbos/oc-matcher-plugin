<?php namespace Shohabbos\Matcher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosMatcherLists3 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_matcher_lists', function($table)
        {
            $table->dropColumn('id');
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_matcher_lists', function($table)
        {
            $table->integer('id')->unsigned();
        });
    }
}
