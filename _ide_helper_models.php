<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\ExtendedChat
 *
 * @property int $id
 * @property int|null $contact_id
 * @property int|null $attendant_id
 * @property int|null $company_id
 * @property int|null $source
 * @property int|null $response_to
 * @property string|null $message
 * @property int|null $type_id
 * @property string|null $data
 * @property int|null $status_id
 * @property int|null $socialnetwork_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedChat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedChat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedChat query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedChat whereAttendantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedChat whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedChat whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedChat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedChat whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedChat whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedChat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedChat whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedChat whereResponseTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedChat whereSocialnetworkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedChat whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedChat whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedChat whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedChat whereUpdatedAt($value)
 */
	class ExtendedChat extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExtendedAttendantsContact
 *
 * @property int $id
 * @property int|null $attendant_id
 * @property int|null $contact_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\UsersAttendant|null $attendant
 * @property-read \App\Models\Contact|null $contact
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedAttendantsContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedAttendantsContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedAttendantsContact query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedAttendantsContact whereAttendantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedAttendantsContact whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedAttendantsContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedAttendantsContact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedAttendantsContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedAttendantsContact whereUpdatedAt($value)
 */
	class ExtendedAttendantsContact extends \Eloquent {}
}

namespace App\Models{
/**
 * Class AttendantsContact
 *
 * @package App\Models
 * @version September 27, 2019, 3:37 pm UTC
 * @property \App\Models\UsersAttendant attendant
 * @property \App\Models\Contact contact
 * @property \Illuminate\Database\Eloquent\Collection
 * @property integer attendant_id
 * @property integer contact_id
 * @property int $id
 * @property int|null $attendant_id
 * @property int|null $contact_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\UsersAttendant|null $attendant
 * @property-read \App\Models\Contact|null $contact
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttendantsContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttendantsContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttendantsContact query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttendantsContact whereAttendantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttendantsContact whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttendantsContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttendantsContact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttendantsContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttendantsContact whereUpdatedAt($value)
 */
	class AttendantsContact extends \Eloquent {}
}

namespace App\Models{
/**
 * Class UsersSeller
 *
 * @package App\Models
 * @version October 30, 2019, 8:28 pm UTC
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection 1s
 * @property \Illuminate\Database\Eloquent\Collection 2s
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersSeller newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersSeller newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersSeller query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersSeller whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersSeller whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersSeller whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersSeller whereUserId($value)
 */
	class UsersSeller extends \Eloquent {}
}

namespace App\Models{
/**
 * Class MessagesType
 *
 * @package App\Models
 * @version November 7, 2019, 8:04 pm UTC
 * @property string name
 * @property string description
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessagesType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessagesType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessagesType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessagesType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessagesType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessagesType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessagesType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessagesType whereUpdatedAt($value)
 */
	class MessagesType extends \Eloquent {}
}

namespace App\Models{
/**
 * Class UsersAttendant
 *
 * @package App\Models
 * @version September 27, 2019, 5:25 pm UTC
 * @property \App\Models\User user
 * @property \App\Models\User userManager
 * @property \Illuminate\Database\Eloquent\Collection attendantsContacts
 * @property \Illuminate\Database\Eloquent\Collection
 * @property integer user_id
 * @property integer code
 * @property integer selected_contact_id
 * @property integer user_manager_id
 * @property integer code
 * @property int $user_id
 * @property int|null $user_manager_id
 * @property int|null $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $selected_contact_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttendantsContact[] $attendantsContacts
 * @property-read int|null $attendants_contacts_count
 * @property-read \App\Models\User $user
 * @property-read \App\Models\User|null $userManager
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersAttendant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersAttendant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersAttendant query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersAttendant whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersAttendant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersAttendant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersAttendant whereSelectedContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersAttendant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersAttendant whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersAttendant whereUserManagerId($value)
 */
	class UsersAttendant extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExtendedContact
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property string|null $description
 * @property string|null $remember
 * @property string|null $summary
 * @property string|null $phone
 * @property string $whatsapp_id
 * @property string|null $facebook_id
 * @property string|null $instagram_id
 * @property string|null $linkedin_id
 * @property string $json_data
 * @property int|null $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttendantsContact[] $attendantsContacts
 * @property-read int|null $attendants_contacts_count
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\AttendantsContact $latestAttendant
 * @property-read \App\Models\AttendantsContact $latestAttendantContact
 * @property-read \App\Models\ContactsStatus|null $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact whereFacebookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact whereInstagramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact whereJsonData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact whereLinkedinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact whereRemember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedContact whereWhatsappId($value)
 */
	class ExtendedContact extends \Eloquent {}
}

namespace App\Models{
/**
 * Class SystemConfig
 *
 * @package App\Models
 * @version September 13, 2019, 9:29 pm UTC
 * @property \Illuminate\Database\Eloquent\Collection
 * @property string name
 * @property string value
 * @property string description
 * @property int $id
 * @property string $name
 * @property string|null $value
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemConfig query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemConfig whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemConfig whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemConfig whereValue($value)
 */
	class SystemConfig extends \Eloquent {}
}

namespace App\Models{
/**
 * Class UsersManager
 *
 * @package App\Models
 * @version September 27, 2019, 5:26 pm UTC
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection 1s
 * @property \Illuminate\Database\Eloquent\Collection 2s
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UsersAttendant[] $Attendants
 * @property-read int|null $attendants_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersManager newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersManager newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersManager query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersManager whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersManager whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersManager whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersManager whereUserId($value)
 */
	class UsersManager extends \Eloquent {}
}

namespace App\Models{
/**
 * Class User
 *
 * @package App\Models
 * @version September 27, 2019, 5:25 pm UTC
 * @property \App\Models\Company company
 * @property \App\Models\Role role
 * @property \App\Models\UsersStatus status
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection 1s
 * @property \Illuminate\Database\Eloquent\Collection 2s
 * @property \App\Models\UsersManager usersManager
 * @property integer id
 * @property integer company_id
 * @property string name
 * @property string email
 * @property string whatsapp_id
 * @property string facebook_id
 * @property string instagram_id
 * @property string linkedin_id
 * @property string|\Carbon\Carbon email_verified_at
 * @property string password
 * @property string remember_token
 * @property string login
 * @property string CPF
 * @property string phone
 * @property string image_path
 * @property integer role_id
 * @property integer status_id
 * @property int $id
 * @property int|null $company_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $whatsapp_id
 * @property string|null $facebook_id
 * @property string|null $instagram_id
 * @property string|null $linkedin_id
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property string|null $login
 * @property string|null $CPF
 * @property string|null $phone
 * @property string $image_path
 * @property int|null $role_id
 * @property int|null $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $mute_notifications
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\Role|null $role
 * @property-read \App\Models\UsersStatus|null $status
 * @property-read \App\Models\UsersManager $usersManager
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCPF($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFacebookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereInstagramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLinkedinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereMuteNotifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereWhatsappId($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Chat
 *
 * @package App\Models
 * @version October 31, 2019, 4:12 pm UTC
 * @property integer contact_id
 * @property integer attendant_id
 * @property integer source
 * @property string message
 * @property integer type_id
 * @property string data
 * @property integer status_id
 * @property integer socialnetwork_id
 * @property int $id
 * @property int|null $contact_id
 * @property int|null $attendant_id
 * @property int|null $company_id
 * @property int|null $source
 * @property int|null $response_to
 * @property string|null $message
 * @property int|null $type_id
 * @property string|null $data
 * @property int|null $status_id
 * @property int|null $socialnetwork_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereAttendantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereResponseTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereSocialnetworkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereUpdatedAt($value)
 */
	class Chat extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ContactsStatus
 *
 * @package App\Models
 * @version September 26, 2019, 1:32 am UTC
 * @property \Illuminate\Database\Eloquent\Collection
 * @property string name
 * @property string description
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactsStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactsStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactsStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactsStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactsStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactsStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactsStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContactsStatus whereUpdatedAt($value)
 */
	class ContactsStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MyModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MyModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MyModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MyModel query()
 */
	class MyModel extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Company
 *
 * @package App\Models
 * @version September 27, 2019, 5:24 pm UTC
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection contacts
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection 1s
 * @property string CNPJ
 * @property string name
 * @property string phone
 * @property string email
 * @property string description
 * @property int $id
 * @property int|null $user_seller_id
 * @property int|null $rpi_id
 * @property string|null $CNPJ
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $whatsapp
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $amount_attendants
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contact[] $contacts
 * @property-read int|null $contacts_count
 * @property-read \App\Models\Rpi $rpi
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereAmountAttendants($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereCNPJ($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereRpiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereUserSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereWhatsapp($value)
 */
	class Company extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Rpi
 *
 * @package App\Models
 * @version November 30, 2019, 5:50 pm -03
 * @property integer company_id
 * @property string mac
 * @property string tunnel
 * @property string ip
 * @property string password
 * @property string data
 * @property string soft_version
 * @property string soft_version_date
 * @property int $id
 * @property string $mac
 * @property string|null $api_tunnel
 * @property string|null $api_user
 * @property string|null $api_password
 * @property string|null $tcp_tunnel
 * @property string|null $tcp_port
 * @property string|null $root_user
 * @property string|null $root_password
 * @property string|null $ip
 * @property string|null $data
 * @property string|null $soft_version
 * @property string|null $soft_version_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rpi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rpi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rpi query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rpi whereApiPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rpi whereApiTunnel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rpi whereApiUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rpi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rpi whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rpi whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rpi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rpi whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rpi whereMac($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rpi whereRootPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rpi whereRootUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rpi whereSoftVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rpi whereSoftVersionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rpi whereTcpPort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rpi whereTcpTunnel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rpi whereUpdatedAt($value)
 */
	class Rpi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExtendedUsersManager
 *
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UsersAttendant[] $Attendants
 * @property-read int|null $attendants_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedUsersManager newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedUsersManager newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedUsersManager query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedUsersManager whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedUsersManager whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedUsersManager whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtendedUsersManager whereUserId($value)
 */
	class ExtendedUsersManager extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Role
 *
 * @package App\Models
 * @version September 13, 2019, 9:07 pm UTC
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property string name
 * @property string description
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * Class MessagesStatus
 *
 * @package App\Models
 * @version September 26, 2019, 1:32 am UTC
 * @property \Illuminate\Database\Eloquent\Collection
 * @property string name
 * @property string description
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessagesStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessagesStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessagesStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessagesStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessagesStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessagesStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessagesStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessagesStatus whereUpdatedAt($value)
 */
	class MessagesStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Contact
 *
 * @package App\Models
 * @version September 27, 2019, 5:25 pm UTC
 * @property \App\Models\Company company
 * @property \App\Models\ContactsStatus status
 * @property \Illuminate\Database\Eloquent\Collection attendantsContacts
 * @property \Illuminate\Database\Eloquent\Collection
 * @property integer company_id
 * @property string first_name
 * @property string last_name
 * @property string email
 * @property string description
 * @property string remember
 * @property string summary
 * @property string phone
 * @property string whatsapp_id
 * @property string facebook_id
 * @property string instagram_id
 * @property string linkedin_id
 * @property integer status_id
 * @property int $id
 * @property int|null $company_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property string|null $description
 * @property string|null $remember
 * @property string|null $summary
 * @property string|null $phone
 * @property string $whatsapp_id
 * @property string|null $facebook_id
 * @property string|null $instagram_id
 * @property string|null $linkedin_id
 * @property string $json_data
 * @property int|null $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttendantsContact[] $attendantsContacts
 * @property-read int|null $attendants_contacts_count
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\AttendantsContact $latestAttendant
 * @property-read \App\Models\AttendantsContact $latestAttendantContact
 * @property-read \App\Models\ContactsStatus|null $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereFacebookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereInstagramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereJsonData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereLinkedinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereRemember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereWhatsappId($value)
 */
	class Contact extends \Eloquent {}
}

namespace App\Models{
/**
 * Class PasswordReset
 *
 * @package App\Models
 * @version September 13, 2019, 9:13 pm UTC
 * @property \Illuminate\Database\Eloquent\Collection
 * @property string email
 * @property string token
 * @property string $email
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PasswordReset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PasswordReset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PasswordReset query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PasswordReset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PasswordReset whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PasswordReset whereToken($value)
 */
	class PasswordReset extends \Eloquent {}
}

namespace App\Models{
/**
 * Class UsersStatus
 *
 * @package App\Models
 * @version September 26, 2019, 1:31 am UTC
 * @property \Illuminate\Database\Eloquent\Collection
 * @property string name
 * @property string description
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersStatus whereUpdatedAt($value)
 */
	class UsersStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Socialnetwork
 *
 * @package App\Models
 * @version November 5, 2019, 12:50 am UTC
 * @property string name
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Socialnetwork newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Socialnetwork newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Socialnetwork query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Socialnetwork whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Socialnetwork whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Socialnetwork whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Socialnetwork whereUpdatedAt($value)
 */
	class Socialnetwork extends \Eloquent {}
}

namespace App{
/**
 * Class User
 *
 * @package App\Models
 * @version September 27, 2019, 5:25 pm UTC
 * @property \App\Models\Company company
 * @property \App\Models\Role role
 * @property \App\Models\UsersStatus status
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection 1s
 * @property \Illuminate\Database\Eloquent\Collection 2s
 * @property \App\Models\UsersManager usersManager
 * @property integer id
 * @property integer company_id
 * @property string name
 * @property string email
 * @property string whatsapp_id
 * @property string facebook_id
 * @property string instagram_id
 * @property string linkedin_id
 * @property string|\Carbon\Carbon email_verified_at
 * @property string password
 * @property string remember_token
 * @property string login
 * @property string CPF
 * @property string phone
 * @property string image_path
 * @property integer role_id
 * @property integer status_id
 * @property int $id
 * @property int|null $company_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $whatsapp_id
 * @property string|null $facebook_id
 * @property string|null $instagram_id
 * @property string|null $linkedin_id
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property string|null $login
 * @property string|null $CPF
 * @property string|null $phone
 * @property string $image_path
 * @property int|null $role_id
 * @property int|null $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $mute_notifications
 * @property-read \App\Models\Company|null $company
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Role|null $role
 * @property-read \App\Models\UsersStatus|null $status
 * @property-read \App\Models\UsersManager $usersManager
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCPF($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFacebookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereInstagramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLinkedinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMuteNotifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereWhatsappId($value)
 */
	class User extends \Eloquent {}
}

