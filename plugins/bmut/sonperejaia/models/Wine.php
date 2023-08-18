<?php namespace Bmut\SonPereJaia\Models;

use Model;

/**
 * Model
 */
class Wine extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;


    /**
     * @var bool timestamps are disabled.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = [
        'name',
        ['slug', 'index' => true],
        'description',
        'type',
        'type_grape',
        'color'        
    ];

    /**
     * @var string table in the database used by the model.
     */
    public $table = 'bmut_sonperejaia_wine';

    protected $slugs = ['slug' => 'name'];


    public $attachOne = [
        'img' => \System\Models\File::class
    ];

    /**
     * @var array rules for validation.
     */
    public $rules = [
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
