<?php namespace CodeJunkie\Newsletter\Components;

use Cms\Classes\ComponentBase;

use CodeJunkie\NewsLetter\Models\News;

class ListNews extends ComponentBase
{

      /**
     * This is body of the Newsletter
     * @var array
     */
    public $newsCollection;
      /**
     * Details of the Newsletter
     * @var array
     */
    public $newsDetails;
    public $name3;


    public function componentDetails()
    {
        return [
            'name'        => 'ListNews Component',
            'description' => 'Displaying all the News'
        ];
    }

    public function defineProperties()
    {
        return [];
    }


    //this will run but not for ajax events
    public function onRun()
    {
        $this->newsCollection = News::all();
    }

    public function onDeleteNewsLetter(){
        $id = post('news_id');

        $news =  News::find($id);

        $news->delete();

    }
}
