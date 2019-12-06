<?php

namespace App\Repositories;

use App\Models\ExtendedAttendantsContact;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AttendantsContactRepository
 * @package App\Repositories
 * @version September 27, 2019, 3:37 pm UTC
 *
 * @method AttendantsContact findWithoutFail($id, $columns = ['*'])
 * @method AttendantsContact find($id, $columns = ['*'])
 * @method AttendantsContact first($columns = ['*'])
*/
class ExtendedAttendantsContactRepository extends AttendantsContactRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'attendant_id',
        'contact_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ExtendedAttendantsContact::class;
    }

    public function deleteAllByContanct(int $contact_id)
    {
        ExtendedAttendantsContact::where("contact_id", $contact_id)->delete();
        
    }

    // public function deleteAllByAttendant(int $attendant_id)
    // {
    //     ExtendedAttendantsContact::where("attendant_id", $attendant_id)->delete();
        
    // }
}
