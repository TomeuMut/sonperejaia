<?php namespace Bmut\SonPereJaia\Models;

use Model;

/**
 * Model
 */
class Contact extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'bmut_sonperejaia_contact';

    /**
     * @var array rules for validation.
     */
    public $rules = [
    ];
    
    public $fillable = ['name','email','text','phone'];


}
