<?php namespace CodeJunkie\Scores\Components;

use Cms\Classes\ComponentBase;

use CodeJunkie\Scores\Models\Scored;

use Carbon\Carbon;
class ListSearches extends ComponentBase
{
      /**
     * This is body of the Newsletter
     * @var array
     */
    public $search_results;
    public function componentDetails()
    {
        return [
            'name'        => 'ListSearches Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->search_results = Scored::all();

        //==========================================================
        //============== FILTERED RESULTS ==========================
        //==========================================================
        //for THIS DAY
        $carbon = Carbon::now();
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $this->page['search_results_today'] = Scored::where('created_at', '>', $today)->where('created_at', '<', $tomorrow)->get();

        //for THIS WEEK
        $start_of_week = Carbon::now()->startOfWeek();
        $end_of_week = Carbon::now()->endOfWeek();
       $this->page['search_results_weekly'] = Scored::where('created_at', '>', $start_of_week)->where('created_at', '<', $end_of_week)->get();

       //for THIS WEEK
        $start_of_month = Carbon::now()->startOfMonth();
        $end_of_month = Carbon::now()->endOfMonth();
       $this->page['search_results_monthly'] = Scored::where('created_at', '>', $start_of_month)->where('created_at', '<', $end_of_month)->get();


    }
}
