<?php namespace Shohabbos\Matcher\Models;

use Model;
use RainLab\User\Models\User;

/**
 * Model
 */
class ListItem extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'shohabbos_matcher_lists';

    public $guarded = ['id'];
    

    public $belongsTo = [
        'profile' => [User::class]
    ];


}
