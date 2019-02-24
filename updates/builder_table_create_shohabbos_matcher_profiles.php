<?php namespace Shohabbos\Matcher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateShohabbosMatcherProfiles extends Migration
{
    public function up()
    {
        Schema::create('shohabbos_matcher_profiles', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id');
            $table->string('nationality')->nullable();
            $table->string('laguage')->nullable();
            $table->string('gender')->nullable();
            $table->string('relationship_status')->nullable();
            $table->string('age')->nullable();
            $table->string('children')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('education')->nullable();
            $table->string('job')->nullable();
            $table->string('profession')->nullable();
            $table->string('contact')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('shohabbos_matcher_profiles');
    }
}
