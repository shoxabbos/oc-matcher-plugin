<?php namespace Shohabbos\Matcher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosMatcherLists extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_matcher_lists', function($table)
        {
            $table->renameColumn('listable_id', 'profile_id');
            $table->renameColumn('listable_type', 'type');
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_matcher_lists', function($table)
        {
            $table->renameColumn('profile_id', 'listable_id');
            $table->renameColumn('type', 'listable_type');
        });
    }
}
