<?php namespace Bmut\Utils\Models;

use Model;

/**
 * Model
 */
class Script extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $implement = ['bmut.utils.Behaviors.ActivatableModel'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bmut_utils_scripts';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
