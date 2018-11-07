<?php namespace CodeJunkie\Scores\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCollegesTable extends Migration
{
    public function up()
    {
        Schema::create('codejunkie_scores_colleges', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('college_name_short');
            $table->string('college_name_full');
            $table->integer('sat_min_score');
            $table->integer('sat_max_score');
            $table->float('gpa_min_score', 2,1);
            $table->float('gpa_max_score', 2,1);
            $table->integer('act_min_score');
            $table->integer('act_max_score');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('codejunkie_scores_colleges');
    }
}
