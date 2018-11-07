<?php namespace CodeJunkie\Newsletter;

use Backend;
use System\Classes\PluginBase;

/**
 * Newsletter Plugin Information File
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
            'name'        => 'Newsletter',
            'description' => 'Custom Plugin for management of newsletter',
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
            'CodeJunkie\Newsletter\Components\AddNews' => 'AddNews',
            'CodeJunkie\Newsletter\Components\ListNews' => 'ListNews',
            // 'CodeJunkie\Newsletter\Components\AddSubscriber' => 'AddSubscriber',
            'CodeJunkie\Newsletter\Components\ListSubscribers' => 'ListSubscribers',
            'CodeJunkie\Newsletter\Components\EditNews' => 'EditNews',
            'CodeJunkie\Newsletter\Components\DeleteNewsLetter' => 'DeleteNewsLetter',
            'CodeJunkie\Newsletter\Components\Subscribers' => 'Subscribers',
            'CodeJunkie\Newsletter\Components\GoogleAnalytics' => 'GoogleAnalytics',

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
            'codejunkie.newsletter.some_permission' => [
                'tab' => 'Newsletter',
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
            'newsletter' => [
                'label'       => 'Newsletter',
                'url'         => Backend::url('codejunkie/newsletter/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['codejunkie.newsletter.*'],
                'order'       => 500,
            ],
        ];
    }
}
