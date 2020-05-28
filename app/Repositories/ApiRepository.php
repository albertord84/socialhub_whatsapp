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

    public function apiMessagesByCompany($company_id, int $page = null, string $searchInput = '')
    {
        $Api = new Api();
        $Api->table = "$company_id";

        $page_length = env('APP_TRACKING_PAGE_LENGTH_FOR_MANAGER', 100);
        $start = $page_length * $page;

        // return $Api->with(['contact', 'status'])->slice($start, $page_length)->all();
        if($searchInput == ''){
            $Api = $Api
                ->get()->slice($start, $page_length)->each(function(Api $Api) {
                $Api->Contact = $Api->contact()->first();
                $Api->last_tracking = $Api->last_tracking();
            });
        } else{
            $Api = $Api
                ->where('json_csv_data', 'LIKE', '%'. $searchInput.'%')
                ->orWhere('tracking_code', 'LIKE', '%'. $searchInput.'%')
                ->orWhere('tracking_list', 'LIKE', '%'. $searchInput.'%')
                ->get()->slice($start, $page_length)->each(function(Api $Api) {
                $Api->Contact = $Api->contact()->first();
                $Api->last_tracking = $Api->last_tracking();
            });
        }

        return $Api;
    }    
}
