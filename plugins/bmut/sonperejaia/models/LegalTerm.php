<?php namespace Bmut\SonPereJaia\Models;

use Model;

/**
 * Model
 */
class LegalTerm extends Model
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
    public $table = 'bmut_sonperejaia_legal_terms';

    /**
     * @var array rules for validation.
     */
    public $rules = [
    ];

}
