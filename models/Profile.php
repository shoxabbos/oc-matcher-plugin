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

    protected $jsonable = ['properties'];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $guarded = ['id'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'shohabbos_matcher_profiles';

    public $belongsTo = [
        'user' => 'RainLab\User\Models\User'
    ];

    public static function getFromUser($user) {
        if ($user->profile) {
            return $user->profile;
        }

        $profile = new static;
        $profile->user = $user;
        $profile->save();


        $user->profile = $profile;

        return $profile;
    } 

    public $attachOne = [
        'photo' => 'System\Models\File'
    ];

    public $attachMany = [
        'photos' => 'System\Models\File'
    ];

    public $hasMany = [
        'list' => [ListItem::class]
    ];

    /**
     * The attributes on which the post list can be ordered.
     * @var array
     */
    public static $allowedSortingOptions = [
        'created_at asc '   => 'rainlab.blog::lang.sorting.created_asc',
        'created_at desc'   => 'rainlab.blog::lang.sorting.created_desc',
        'updated_at asc'    => 'rainlab.blog::lang.sorting.updated_asc',
        'updated_at desc'   => 'rainlab.blog::lang.sorting.updated_desc',
        'random'            => 'rainlab.blog::lang.sorting.random'
    ];
    

    /**
     * Lists posts for the API
     *
     * @param        $query
     * @param  array $options Display options
     * @return Post
     */
    public function scopeListApi($query, $options)
    {
        /*
         * Default options
         */
        extract(array_merge([
            'page'             => 1,
            'perPage'          => 30,
            'sort'             => 'created_at',
            'categories'       => null,
            'exceptCategories' => null,
            'category'         => null,
            'search'           => '',
            'published'        => true,
            'exceptPost'       => null
        ], $options));

        $searchableFields = ['name', 'surname', 'middlename'];

        /*
         * Ignore a post
         */
        if ($exceptPost) {
            $query->where('id', '<>', $exceptPost);
        }

        /*
         * Sorting
         */
        if (in_array($sort, array_keys(static::$allowedSortingOptions))) {
            if ($sort == 'random') {
                $query->inRandomOrder();
            } else {
                @list($sortField, $sortDirection) = explode(' ', $sort);
                if (is_null($sortDirection)) {
                    $sortDirection = "desc";
                }
                $query->orderBy($sortField, $sortDirection);
            }
        }

        /*
         * Search
         */
        $search = trim($search);
        if (strlen($search)) {
            $query->searchWhere($search, $searchableFields);
        }

        return $query->paginate($perPage, $page);
    }




    





    public function getGenderOptions() {
        return $this->getPropertyValues('gender');
    }

    public function getNationalityOptions() {
        return $this->getPropertyValues('nationality');
    }

    public function getRelationshipStatusOptions() {
        return $this->getPropertyValues('relationship_status');
    }

    public function getEducationOptions() {
        return $this->getPropertyValues('education');
    }


    private function getPropertyValues($key) {
        $model = Property::where('key', $key)->first();

        if (!$model) {
            return ['--none--'];
        }

        return $model->children()->lists('value', 'key');
    }


}
