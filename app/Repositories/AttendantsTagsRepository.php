<?php

namespace App\Repositories;

use App\Models\AttendantsTags;
use Illuminate\Database\Eloquent\Collection;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AttendantsTagsRepository
 * @package App\Repositories
 * @version April 2, 2020, 8:00 am -03
 *
 * @method AttendantsTags findWithoutFail($id, $columns = ['*'])
 * @method AttendantsTags find($id, $columns = ['*'])
 * @method AttendantsTags first($columns = ['*'])
*/
class AttendantsTagsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'attendant_id',
        'name',
        'color'
    ];

    public function attendantTags($attendant_id): Collection
    {
        $attendantTags = $this->findWhere(['attendant_id' => $attendant_id]);
        return $attendantTags;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AttendantsTags::class;
    }
}
