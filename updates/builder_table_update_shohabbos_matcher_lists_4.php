<?php namespace Shohabbos\Matcher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosMatcherLists4 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_matcher_lists', function($table)
        {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned()->change();
            $table->integer('profile_id')->unsigned()->change();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_matcher_lists', function($table)
        {
            $table->dropColumn('id');
            $table->integer('user_id')->unsigned(false)->change();
            $table->integer('profile_id')->unsigned(false)->change();
        });
    }
}
