<?php namespace CodeJunkie\NewsLetter\Components;

use Cms\Classes\ComponentBase;

use CodeJunkie\NewsLetter\Models\News;

class EditNews extends ComponentBase
{
    public $newsCollection;
    public $newsId ;

    public function componentDetails()
    {
        return [
            'name'        => 'EditNews Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $id = post('news_id'); // getting the id of the post
        $this->newsCollection = News::find($id);
     }


    public function onEditNews(){
        $id = post('news_id');
        //editing
        $postTitle = post('title');
        $postSubject = post('subject');
        $postBody = post('body');

        $news =  News::find($id);
        $news->title = $postTitle;
        $news->subject = $postSubject;
        $news->body = $postBody;
        $news->save();
    }

    public function onDelete()
    {
        $id = post('news_id');

        $news =  News::find($id);

        $news->delete();

    }

}
