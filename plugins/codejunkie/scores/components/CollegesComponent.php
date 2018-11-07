<?php namespace CodeJunkie\Scores\Components;

use Cms\Classes\ComponentBase;

use CodeJunkie\Scores\Models\College;

use Flash;

class CollegesComponent extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Colleges_component Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
    public function onAddCollege( )
    {
        $college_name_short = post('college_name_short');
        $college_name_full = post('college_name_full');
        $sat_max = post('sat_max');
        $act_max = post('act_max');
        $gpa_max = post('gpa_max');
        $sat_min = post('sat_min');
        $act_min = post('act_min');
        $gpa_min = post('gpa_min');

        $college = new College;
        $college->college_name_short = $college_name_short;
        $college->college_name_full = $college_name_full;
        $college->sat_max_score = $sat_max;
        $college->sat_min_score = $sat_min;
        $college->gpa_max_score = $gpa_max;
        $college->gpa_min_score = $gpa_min;
        $college->act_max_score = $act_max;
        $college->act_min_score = $act_min;

        $college->save();
        Flash::success('College details added successfully!');
    }

    public function onRun()
    {
        $this->page['colleges']  = $colleges = College::all();
        if(post('college_id')){
            $this->page['college']  = $colleges = College::find(post('college_id'));
        }

    }

    public function onAEditCollege()
    {
        $college_name_short = post('college_name_short');
        $college_name_full = post('college_name_full');
        $sat_max = post('sat_max_score');
        $act_max = post('act_max_score');
        $gpa_max = post('gpa_max_score');
        $sat_min = post('sat_min_score');
        $act_min = post('act_min_score');
        $gpa_min = post('gpa_min_score');

        $college = College::find(post('college_id'));
        $college->college_name_short = $college_name_short;
        $college->college_name_full = $college_name_full;
        $college->sat_max_score = $sat_max;
        $college->sat_min_score = $sat_min;
        $college->gpa_max_score = $gpa_max;
        $college->gpa_min_score = $gpa_min;
        $college->act_max_score = $act_max;
        $college->act_min_score = $act_min;

        if($college->save())
        {
            Flash::success('College details added successfully!');
        }else{
            Flash::error('College details could not be added!');
        }
    }

    public function onDeleteCollege(){
        $id = post('college_id');

        $college =  College::find($id);

        if($college->delete())
        {
            Flash::success('College details deleted successfully!');
        }else{
            Flash::error('College details could not be deleted!');
        }

    }


}
