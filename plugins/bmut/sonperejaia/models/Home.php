<?php namespace Bmut\SonPereJaia\Models;

use Model;

/**
 * Model
 */
class Home extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var bool timestamps are disabled.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string table in the database used by the model.
     */
    public $table = 'bmut_sonperejaia_home';

    /**
     * @var array rules for validation.
     */
    public $rules = [
    ];

    public $attachOne = [
        'block_two_img' => \System\Models\File::class,
        'block_three_img_one' => \System\Models\File::class,
        'block_three_img_two' => \System\Models\File::class,
        'block_four_img' => \System\Models\File::class,        
    ];

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = [
        'block_one_title',
        'block_one_subtitle',
        'block_one_description',
        'block_two_title',
        'block_three_title',
        'block_three_description',
        'block_three_title_2',
        'block_three_description_2',
        'block_four_title',
    ];

}
