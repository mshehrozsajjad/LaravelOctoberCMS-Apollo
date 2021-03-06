<?php namespace CodeJunkie\Scores\Models;

use Model;

/**
 * UserData Model
 */
class UserData extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'codejunkie_scores_user_datas';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
