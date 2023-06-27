<?php namespace Bmut\SonPereJaia\Models;

use Model;

/**
 * Model
 */
class Tag extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;

    /**
     * @var bool timestamps are disabled.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string table in the database used by the model.
     */
    public $table = 'bmut_sonperejaia_tags';
    
    protected $slugs = ['slug' => 'name'];

    /**
     * @var array rules for validation.
     */
    public $rules = [
    ];

    public $hasOne  = [
        'gallery' => ['bmut\sonperejaia\Models\Gallery']
    ];


}
