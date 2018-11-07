<?php namespace CodeJunkie\Scores\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateScoresTable extends Migration
{
    public function up()
    {
        Schema::create('codejunkie_scores_scores', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('satScore');
            $table->integer('actScore');
            $table->float('gpaScore', 2,1);
            $table->integer('likelihood_percentage');  //integer presentation of likelihood of acceptance
            $table->string('likelihood');  //string presentation of likelihood of acceptance
            $table->string('college');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('codejunkie_scores_scores');
    }
}
