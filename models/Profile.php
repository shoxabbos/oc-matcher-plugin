<?php namespace Shohabbos\Matcher\Models;

use Model;

/**
 * Model
 */
class Profile extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $guarded = ['id', 'user_id'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'shohabbos_matcher_profiles';
}
