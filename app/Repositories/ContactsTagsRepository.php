<?php

namespace App\Repositories;

use App\Models\ContactsTags;
use Illuminate\Database\Eloquent\Collection;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ContactsTagsRepository
 * @package App\Repositories
 * @version April 2, 2020, 9:47 pm -03
 *
 * @method ContactsTags findWithoutFail($id, $columns = ['*'])
 * @method ContactsTags find($id, $columns = ['*'])
 * @method ContactsTags first($columns = ['*'])
*/
class ContactsTagsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'contact_id',
        'attendant_id',
        'attendant_tag_id'
    ];

    public function contactTags($contact_id): Collection
    {
        $contactTags = $this->findWhere(['attendant_id' => $contact_id]);
        return $contactTags;
    }


    /**
     * Configure the Model
     **/
    public function model()
    {
        return ContactsTags::class;
    }
}
