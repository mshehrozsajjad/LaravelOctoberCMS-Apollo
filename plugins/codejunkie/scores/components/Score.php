<?php namespace CodeJunkie\Scores\Components;

use Cms\Classes\ComponentBase;

use CodeJunkie\Scores\Models\College;
use CodeJunkie\Scores\Models\Scored;

use Validator;

use ValidationException;

use Flash;

use DB;

class Score extends ComponentBase
{
    public $data=[];
    public $colleges_data;

    public function componentDetails()
    {
        return [
            'name'        => 'score Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->page['colleges_data'] = DB::table('codejunkie_scores_colleges')->select('college_name_short','college_name_full')->get();
     }

    public function onSubmitCalculate()
    {
        $college_name   = explode("-", post('collegeName'));
        $college_name = $college_name['0'];
        $user_sat_score = post('SAT');
        $user_gpa_score = post('GPA');
        $user_act_score = post('ACT');

        if($user_gpa_score > 4.000 || $user_gpa_score <0.0000){
            Flash::error('Please provide a valid GPA score');
            return;
        }
        if($user_act_score == '' && $user_sat_score == ''){
            Flash::error('Please enter either SAT score or ACT score or Both');
            return;
        }

        $messages = [
            'gpa_Score.required' => 'The GPA field is required.',
            'sat_Score.between' => 'Your SAT Score needs to be in the range of 400-1600.',
             'act_Score.between' => 'Your ACT Score needs to be in the range of 1-36.',
            'collegeName.not_in' => 'A College name needs to be selected from the list'
        ];
        $validator = Validator::make(
            [
                'collegeName' => $college_name,
                'sat_Score' => $user_sat_score,
                'gpa_Score' => $user_gpa_score,
                'act_Score' => $user_act_score,
            ],
            [
                'collegeName' => 'not_in:"Please Select a College"',
                'sat_Score' => 'integer|between:400,1600',
                'act_Score' => 'integer|between:1,36',
                'gpa_Score' => 'required',
            ],
            $messages
        );

        if ( $validator -> fails() ) {
        // The given data did not pass validation
            // throw new ValidationException($validator);
            $messages = $validator->messages();
            $errors = "";
            foreach($messages->all() as $error){
                $errors = $errors."<li>".$error."</li>";
            }
                Flash::error($errors);

        }else{
            $user_data_save_to_DB = new Scored;
            $user_data_save_to_DB->college  = $college_name;
            $user_data_save_to_DB->satScore = $user_sat_score;
            $user_data_save_to_DB->gpaScore = $user_gpa_score;
            $user_data_save_to_DB->actScore = $user_act_score;

            $college = DB::table('codejunkie_scores_colleges')->where('college_name_short', $college_name)->get();
            //mapping buckets of scores accepted by college to ranges
            $sat_max = $college['0']->sat_max_score;
            $sat_min = $college['0']->sat_min_score;
            $gpa_max = $college['0']->gpa_max_score;
            $gpa_min = $college['0']->gpa_min_score;
            $act_max = $college['0']->act_max_score;
            $act_min = $college['0']->act_min_score;

            //range margin e.g., 0-400 first bucket range margin of 1 next bucket will start from 401 onwards
            $sat_range_add_margin = 1;
            $gpa_range_add_margin = 0.01;
            $act_range_add_margin = 0.22;

            //GETTING BUCKETS
            $gpa_bucket = $this->getBucket($gpa_min, $gpa_max, $gpa_range_add_margin);
            $sat_bucket = $this->getBucket($sat_min, $sat_max, $sat_range_add_margin);
            $act_bucket = $this->getBucket($act_min,$act_max, $act_range_add_margin);

            //get GPA acceptance percentage
            //as gpa is required in any case we will make this available for all 3 cases:
            $gpa_acceptance_percentage = $this->getLikelihoodPercentage($user_gpa_score, $gpa_bucket, $gpa_min, $gpa_max);

            if( $college_name !='' && $college_name != "Please Select a College" && $user_sat_score !='' && $user_gpa_score !='' && $user_act_score !='' )
            {
                //get SAT acceptance percentage
                $sat_acceptance_percentage = $this->getLikelihoodPercentage($user_sat_score, $sat_bucket, $sat_min, $sat_max);
                //get ACT acceptance percentage
                $act_acceptance_percentage = $this->getLikelihoodPercentage($user_act_score, $act_bucket, $act_min, $act_max);

                // FINAL ACCEPTANCE PERCENTAGES AFTER APPLYING WEIGHTS
                $user_data_save_to_DB->likelihood_percentage = $final_likelihood_percentage = $this->getLikelihoodAll($sat_acceptance_percentage, $act_acceptance_percentage, $gpa_acceptance_percentage);

                $user_data_save_to_DB->likelihood = $likelihood_from_percentage = $this->getLikelihoodfromPercentage($final_likelihood_percentage);
                $this->page['result'] = $likelihood_from_percentage;
                $user_data_save_to_DB->save();
                return;
            }
            //when we have SAT and GPA score from the user
            if( $user_sat_score !='' && $user_gpa_score !='')
            {
                //get SAT acceptance percentage
                $sat_acceptance_percentage = $this->getLikelihoodPercentage($user_sat_score, $sat_bucket, $sat_min, $sat_max);
                // FINAL ACCEPTANCE PERCENTAGES AFTER APPLYING WEIGHTS
                $user_data_save_to_DB->likelihood_percentage = $final_likelihood_percentage = $this->getLikelihoodSATGPA($sat_acceptance_percentage, $gpa_acceptance_percentage);
                $user_data_save_to_DB->likelihood = $likelihood_from_percentage = $this->getLikelihoodfromPercentage($final_likelihood_percentage);
                $this->page['result'] = $likelihood_from_percentage;
                $user_data_save_to_DB->save();
                return;
            }
            //when we have ACT and GPA score from the user
            if( $user_gpa_score !='' && $user_act_score !='' )
            {
                //get ACT acceptance percentage
                $act_acceptance_percentage = $this->getLikelihoodPercentage($user_act_score, $act_bucket, $act_min, $act_max);
                // FINAL ACCEPTANCE PERCENTAGES AFTER APPLYING WEIGHTS
                $user_data_save_to_DB->likelihood_percentage = $final_likelihood_percentage = $this->getLikelihoodACTGPA($act_acceptance_percentage, $gpa_acceptance_percentage);
                $user_data_save_to_DB->likelihood = $likelihood_from_percentage = $this->getLikelihoodfromPercentage($final_likelihood_percentage);
                $this->page['result'] = $likelihood_from_percentage;
                $user_data_save_to_DB->save();
                return;
            }
            //when we have only the GPA score from the user
            if(  $user_gpa_score !='' && $user_act_score =='' && $user_sat_score =='' )
            {
                $user_data_save_to_DB->likelihood_percentage = $gpa_acceptance_percentage;
                $user_data_save_to_DB->likelihood = $likelihood_from_percentage = $this->getLikelihoodfromPercentage($gpa_acceptance_percentage);
                $this->page['result'] = $likelihood_from_percentage;
                $user_data_save_to_DB->save();
                return;
            }
        }
    }

    //APPLYING WEIGHTS when all are present
    public function getLikelihoodAll($sat_percentage, $act_percentage, $gpa_percentage)
    {
        $x = ($sat_percentage+$act_percentage+($gpa_percentage*1.75))/3.75;
        return $x;
    }
    //APPLYING WEIGHTS SAT and GPA
    public function getLikelihoodSATGPA($sat_percentage, $gpa_percentage)
    {
        $x = ($sat_percentage+($gpa_percentage*1.75))/2.75;
        return $x;
    }
    //APPLYING WEIGHTS ACT and GPA
    public function getLikelihoodACTGPA($act_percentage, $gpa_percentage)
    {
        $x = ($act_percentage+($gpa_percentage*1.75))/2.75;
        return $x;
    }
    //APPLYING WEIGHTS ONLY GPA..RETURN GPA
    public function getLikelihood($gpa_percentage)
    {
        return $gpa_percentage;
    }

    //map division of scores of ACT to likelihoods e.g., 00 - 36.00 VERY UNLIKELY
    public function getBucket($min_score, $max_score, $range_add_margin){
        $un_coff = ($max_score-$min_score)/8;
        $coefficients = [1,3,5,7];
        $score_bucket = array();
        $previous_score = 0; //initial lower bound score
        $buckets = ['VERY UNLIKELY', 'UNLIKELY', 'AVERAGE', 'LIKELY', 'VERY LIKELY'];
        $i = 0;
        foreach ($coefficients as $coefficient) {
            if(!isset($score_bucket[$buckets[$i]])){
                $score_bucket[$buckets[$i]] = array();
            }
            $bucket_score = $un_coff * $coefficient + $min_score;
            $score_bucket[$buckets[$i]][0] = $previous_score;
            $score_bucket[$buckets[$i]][1] = $bucket_score;
            $previous_score = $bucket_score+$range_add_margin;
            $i++;
        }
        $score_bucket[$buckets[4]][0] = $previous_score;
        $score_bucket[$buckets[4]][1] = $max_score;
        return $score_bucket;
    }

    //calculate acceptance likelihood
    //this functions takes in user $score and returns percentage of acceptance = likelihood
    public function getLikelihoodPercentage($score, $score_bucket, $min_score, $max_score)
    {
        $likelihood_percentages = ["VERY UNLIKELY" => 1, "UNLIKELY" => 25, "AVERAGE" => 50 , "LIKELY" => 75, "VERY LIKELY" => 100];
        if ($score < $min_score){
            return 1;
        }
        if ($score > $max_score){
            return 100;
        }
        //go through the buckets and check in which range the score lies
        foreach ($score_bucket as $likelihood => $scr) {
            // $score_bucket['score'] = $score;
            // return $score_bucket;
            if(   $score <= $scr[1] && $score > $scr[0] ){
                return $likelihood_percentages[$likelihood];
            }
        }
    }
    //FINAL STEP: getting likelihood from percentage
    public function getLikelihoodfromPercentage($percentage)
    {
        if($percentage <= 1 ){
            return "VERY UNLIKELY";
        }
        $likelihood_percentages = [
            "VERY UNLIKELY" => array(1,20),
            "UNLIKELY" => array(20, 40),
            "AVERAGE" => array(40, 60),
            "LIKELY" => array(60,80),
            "VERY LIKELY" => array(80,100)
        ];
        if($percentage == 1){
            return "VERY UNLIKELY";
        }else if( $percentage == 100){
            return "VERY LIKELY";
        }
        $keys = array_keys($likelihood_percentages);
        foreach ($likelihood_percentages as $likelihood => $lkd) {
            if(  $lkd[0] < $percentage && $percentage <= $lkd[1] ){
                return array_search($lkd, $likelihood_percentages);
            }
        }
    }
}
