<?php

namespace App\Repositories;

use App\Models\Contact;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ContactRepository
 * @package App\Repositories
 * @version September 27, 2019, 5:04 pm UTC
 *
 * @method Contact findWithoutFail($id, $columns = ['*'])
 * @method Contact find($id, $columns = ['*'])
 * @method Contact first($columns = ['*'])
 */
class ContactRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'first_name',
        'last_name',
        'email',
        'description',
        'remember',
        'summary',
        'phone',
        'whatsapp_id',
        'facebook_id',
        'instagram_id',
        'linkedin_id',
        'status_id',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Contact::class;
    }

}
