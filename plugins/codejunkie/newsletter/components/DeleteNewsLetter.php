<?php namespace CodeJunkie\NewsLetter\Components;

use Cms\Classes\ComponentBase;

use CodeJunkie\NewsLetter\Models\News;


class DeleteNewsLetter extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'DeleteNewsLetter Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onDelete()
    {
        $id = post('news_id'); // getting the id of the post
        if($id){

            $newsCollection = News::find($id);
            $newsCollection->delete();
            return [
                '#myDiv' => $this->renderPartial('admin/admin_newsletter')
            ];
        }

     }

}
