<?php

namespace App\Repositories;

use App\Models\RapidMessages;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RapidMessagesRepository
 * @package App\Repositories
 * @version May 28, 2020, 2:57 pm -03
 *
 * @method RapidMessages findWithoutFail($id, $columns = ['*'])
 * @method RapidMessages find($id, $columns = ['*'])
 * @method RapidMessages first($columns = ['*'])
*/
class RapidMessagesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'message'
    ];

    public function getRapidMessageByAttendantId($attendant_id) {
        return $this->model->where('user_id', $attendant_id)->get();
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RapidMessages::class;
    }
}
