<?php namespace ctmh\CampaignMonitor\Models;

use October\Rain\Database\Model;

/**
 * Twitter settings model
 *
 * @package system
 * @author Alexey Bobkov, Samuel Georges
 *
 */
class Settings extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'rainlab_campaignmonitor_settings';

    public $settingsFields = 'fields.yaml';

    /**
     * Validation rules
     */
    public $rules = [
        'api_key' => 'required'
    ];
}