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

    public function fullContacts()
    {
        $Contacts = DB::table('contacts')->get();
        $Contacts->each(function (Contact $Contact) {
            $Contact->Status = $Contact->status();
            $Contact->lastAttendant = $Contact->attendantsContacts()->latest();
        });

        return $Contacts;

        // try {
        //     $played_contents = DB::table('users_play_contents')
        //         ->join('users', 'users_play_contents.user_id', '=', 'users.id')
        //         ->join('users_students', 'users.id', '=', 'users_students.user_id')
        //         ->join('contents', 'users_play_contents.content_id', '=', 'contents.id')
        //         ->join('courses', 'contents.course_id', '=', 'courses.id');

        //     if ($request->course_id > 0) {
        //         $played_contents = $played_contents->where('course_id', $request->course_id);
        //     }

        //     if ($request->classroom_id > 0) {
        //         $played_contents = $played_contents->where('classroom_id', $request->classroom_id);
        //     }

        //     if ($request->content_id > 0) {
        //         $played_contents = $played_contents->where('content_id', $request->content_id);
        //     }

        //     $played_contents
        //         ->select($columns = [
        //             'CPF', 'email', 'score',
        //             'users.name as student_name',
        //             'users.id as user_id',
        //             'contents.id as content_id',
        //             'contents.url as quiz_id',
        //             'contents.type_id as content_type',
        //             'contents.name as content_name',
        //             'courses.id as course_id',
        //         ])
        //         ->distinct('users_play_contents.user_id');

        //     $played_contents = $played_contents->get();
        //     $played_contents->each(function ($item) {
        //         if ($item->content_type == 4/*Quiz*/) {
        //             $item->score = App(QuizController::class)->get_quiz_user_score($item->user_id, $item->quiz_id);
        //         }

        //     });

        //     $json = $played_contents->toJson();

        //     return $json;
        // } catch (\Throwable $th) {
        //     throw $th;
        // }
    }
}
