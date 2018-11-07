<?php namespace CodeJunkie\Scores;

use Backend;
use System\Classes\PluginBase;

/**
 * Scores Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Scores',
            'description' => 'No description provided yet...',
            'author'      => 'CodeJunkie',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {

        return [
            'CodeJunkie\Scores\Components\Score' => 'Score',
            'CodeJunkie\Scores\Components\CollegesComponent' => 'CollegesComponent',
            'CodeJunkie\Scores\Components\ListSearches' => 'ListSearches',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'codejunkie.scores.some_permission' => [
                'tab' => 'Scores',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'scores' => [
                'label'       => 'Scores',
                'url'         => Backend::url('codejunkie/scores/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['codejunkie.scores.*'],
                'order'       => 500,
            ],
        ];
    }
}
