<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Status
 * @package App\Models
 * @version April 9, 2020, 6:33 pm -03
 *
 * @property string name
 * @property string model
 * @property string description
 */
class Status extends Model
{

    public $table = 'status';

    public $connection = "socialhub_mvp";
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'name',
        // 'model',
        'statusable_type',
        'statusable_id',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        // 'model' => 'string',
        'statusable_type' => 'string',
        'statusable_id' => 'integer',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function statusable(){

        return $this->morphTo();
    }
    
}
