<?php namespace CodeJunkie\Newsletter\Components;

use Cms\Classes\ComponentBase;

use CodeJunkie\Newsletter\Models\Subscriber;

use Validator;

use ValidationException;

use Flash;

class Subscribers extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Subscribers Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onAddSubscriber()
    {
        $validator = Validator::make(
            [
                'first_name' => post('first_name'),
                'last_name' =>  post('last_name'),
                'email' => post('email')
            ],
            [
                'first_name' => 'required|min:3',
                'last_name' => 'required|min:3',
                'email' => 'required|email|unique:codejunkie_newsletter_subscribers'
            ]
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
            $first_name = post('first_name');
            $last_name  = post('last_name');
            $email      = post('email');

            $subscriber  = new Subscriber;
            $subscriber->first_name = $first_name;
            $subscriber->last_name = $last_name;
            $subscriber->email = $email;

            $subscriber->save();
            FLash::success('Subscribed successfully');
        }
    }

    public function onDeleteSubscriber(){
        $subscriber_id = post('subscriber_id');
        if($subscriber_id){
            $subscriber_to_delete = Subscriber::find($subscriber_id);
            $subscriber_to_delete->delete();
        }
    }
}
