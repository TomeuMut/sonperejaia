<?php namespace Bmut\SonPereJaia\Models;

use Model;

/**
 * Model
 */
class Service extends Model
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
    public $table = 'bmut_sonperejaia_services';


    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = [
        'title',
        ['slug', 'index' => true],
        'description',                
    ];
    /**
     * @var array rules for validation.
     */
    public $rules = [];

    protected $slugs = ['slug' => 'title'];


    public $attachOne = [
        'img1' => \System\Models\File::class,
        'img2' => \System\Models\File::class
    ];

    public $attachMany = [
        'galery' => \System\Models\File::class,        
    ];

    public static function translateParams($params, $oldLocale, $newLocale)
    {
        $newParams = $params;
        foreach ($params as $paramName => $paramValue) {
            $records = self::transWhere($paramName, $paramValue, $oldLocale)->first();
            if ($records) {
                $records->translateContext($newLocale);
                $newParams[$paramName] = $records->$paramName;
            }
        }
        return $newParams;
    }

}
