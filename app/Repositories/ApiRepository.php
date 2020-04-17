<?php

namespace App\Repositories;

use App\Models\Api;
use BeyondCode\LaravelWebSockets\Apps\App;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ApiRepository
 * @package App\Repositories
 * @version April 14, 2020, 4:09 pm -03
 *
 * @method Api findWithoutFail($id, $columns = ['*'])
 * @method Api find($id, $columns = ['*'])
 * @method Api first($columns = ['*'])
*/
class ApiRepository extends BaseRepository
{

    public $model;

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'contact_id',
        'sended',
        'message',
        'type_id',
        'data'
    ];

    /**
     * Class constructor.
     */
    // public function __construct()
    // {
    //     parent::__construct(app());
    //     $this->model = new Api();
    // }

    /**
     * Configure the Model
     **/
    public function model()
    {
        // return $this->model;
        return Api::class;
    }
}
