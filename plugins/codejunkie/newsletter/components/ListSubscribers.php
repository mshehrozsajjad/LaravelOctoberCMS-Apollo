<?php namespace CodeJunkie\Newsletter\Components;

use Cms\Classes\ComponentBase;
use CodeJunkie\Newsletter\Models\Subscriber;

class ListSubscribers extends ComponentBase
{
    public $subscribersCollection;
    public function componentDetails()
    {
        return [
            'name'        => 'ListSubscribers Component',
            'description' => 'List all the subscribers from db'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->subscribersCollection = Subscriber::all();
    }

}
