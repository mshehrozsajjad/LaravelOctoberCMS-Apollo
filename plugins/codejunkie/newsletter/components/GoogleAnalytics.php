<?php namespace CodeJunkie\NewsLetter\Components;

use Cms\Classes\ComponentBase;
use Analytics;
use Spatie\Analytics\Period;

use CodeJunkie\Newsletter\Models\Subscriber;

use CodeJunkie\Scores\Models\Scored;

class GoogleAnalytics extends ComponentBase
{
    public $namee ;
    public $mostvisitedpage;
    public $visitorsAndPageViews;
    public $total_subscribers;
    public $active_subscribers;
    public $total_searches;
    public $pageCount;
    public $newData;
    public $todaysData;

    public function componentDetails()
    {
        return [
            'name'        => 'GoogleAnalytics Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        //subscribers count
        $this->total_subscribers = Subscriber::count();
        $this->active_subscribers = Subscriber::where('active', 1)->count();
        $this->page['total_subscribers'] = $this->total_subscribers;
        $this->page['active_subscribers'] = $this->active_subscribers;

        //SEARCH COUNT

        $this->total_searches = Scored::count();
        $this->page['total_searches'] = $this->total_searches;


        //GOOGLE
        $datas = [];
        //fetch the most visited pages for today and the past week

        $datas = Analytics::fetchMostVisitedPages(Period::days(7));

        $this->page['mostvisitedpage']  = $datas;

        $this->pageCount = 0;
        foreach ($datas as $pages) {

            if($pages['url']){
                $this->pageCount += 1;
            }
        }

        $this->page['pageCount'] = $this->pageCount;

        //fetch visitors and page views for today
        // $this->page['todaysData'] = $this->todaysData = Analytics::fetchVisitorsAndPageViews(Period::days(1));
        $todaysData = Analytics::fetchVisitorsAndPageViews(Period::days(1));


        $this->page['todaysPageViews'] = 0;
        foreach ($todaysData as $td ) {
            $this->page['todaysPageViews'] += $td['pageViews'];
        }

        //fetch visitors and page views for the past week
        $this->page['visitorsAndPageViews'] = Analytics::fetchVisitorsAndPageViews(Period::days(7));

        //fetch the most visited pages for today and the past week
        $this->mostvisitedpage = Analytics::fetchMostVisitedPages(Period::days(7));

        //fetch visitors and page views for the past week
        $this->visitorsAndPageViews = Analytics::fetchVisitorsAndPageViews(Period::days(7));

        $i = 0;

        $x = $this->visitorsAndPageViews ;

        $this->newData['totalVisits'] = 0 ;

        foreach($this->visitorsAndPageViews as $visitorandpageview){
            $this->newData['totalVisits'] += $visitorandpageview["pageViews"];
        }
        $this->page['totalPageViews'] = $this->newData['totalVisits'];

    }

}
