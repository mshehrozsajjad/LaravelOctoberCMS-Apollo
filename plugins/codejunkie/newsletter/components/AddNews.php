<?php namespace CodeJunkie\Newsletter\Components;

use Cms\Classes\ComponentBase;

use CodeJunkie\NewsLetter\Models\News;
use CodeJunkie\NewsLetter\Models\Subscriber;

use Mail;
use DB;

class AddNews extends ComponentBase
{

    /**
     * This is title of the Newsletter
     * @var string
     */
    public $title;

        /**
     * This is subject of the Newsletter
     * @var string
     */
    public $subject;

    /**
     * This is body of the Newsletter
     * @var text
     */
    public $body;

    /**
     * This is body of the Newsletter
     * @var text
     */
    public $newsCollection;
    public $name3;



    //these properties title, subject, body will be available in the page as a twig variable

    public function componentDetails()
    {
        return [
            'name'        => 'AddNews Component',
            'description' => 'Adding news to db table'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    //this will execute when the component is first
    //initialized, including AJAX events
    // public function init()
    // { }

    //this will run but not for ajax events
    // public function onRun()
    // {}


      public function  onRun(){
          $this->name3 = "onRun";

        $id = post('news_id');
          if($id != NULL && $id != ''){
            $id = post('news_id'); // getting the id of the post
            $this->newsCollection = News::find($id);
          }
    }

    public function onAddNews()
    {
        $id = post('news_id');

        if($id != NULL && $id != ''){
            //editing
            $postTitle = post('title');
            $postSubject = post('subject');
            $postBody = post('body');

            $news =  News::find($id);
            $news->title = $postTitle;
            $news->subject = $postSubject;
            $news->body = $postBody;
            $news->save();

        }else{

            $postTitle = post('title');
            $postSubject = post('subject');
            $postBody = post('body');

            $news = new News;
            $news->title = $postTitle;
            $news->subject = $postSubject;
            $news->body = $postBody;
            $news->save();
        }
    }

    public function onSendMail()
    {
        $subject = post('news_subject');
        $body = post('news_body');

        //getting all the active users
        $subscribers = DB::table('codejunkie_newsletter_subscribers')->where('active',1)->get();
        //send newsletter to each subscriber
        foreach ($subscribers as $subscriber) {

            $email = $subscriber->email;
            $name = $subscriber->first_name.' '.$subscriber->last_name;

            //the variable which will be displayed on the twig page -> email view page
            $vars = ['subject' => $subject, 'body' =>  $body   ];

            Mail::send('Apollo', $vars, function($message) use ($email,$name) {
                $message->from('noreply@divitech.com', 'Divi Tech Inc.');
                $message->to($email , $name);
                $message->subject("TEST mail subject");

            });
        }

    }

    public function onEditNews()
    {
        $id = post('user_id');
        // $news = News::find($id);
        $this->newsCollection = News::find($id);
     }


     public function onDeleteNewsLetter(){
        $id = post('news_id');

        $news =  News::find($id);

        $news->delete();

    }
}
