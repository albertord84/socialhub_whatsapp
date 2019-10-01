<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Models\UsersAttendant;
use Illuminate\Database\Eloquent\Collection;
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

    public function fullContacts(int $company_id, ?int $attendant_id): Collection
    {
        $Contacts = $this->with('status')->findWhere(['company_id' => $company_id]);
        
        if ($attendant_id) {
            $Attentand = UsersAttendant::with('AttendantsContacts')->find($attendant_id);

            $Contacts = new Collection();
            foreach ($Attentand['AttendantsContacts'] as $key => $AttendantsContact) {
                $AttendantsContactContact = $AttendantsContact->with('contact')->find($AttendantsContact->id);
                $AttendantsContactContactStatus = $AttendantsContactContact['Contact']->with('Status')->find($AttendantsContactContact->contact_id);
                $Contacts[$key] = $AttendantsContactContactStatus;
            }
        }

        return $Contacts;
    }
}
