<?php

namespace App\Business;

use App\Repositories\ExtendedChatRepository;
use Illuminate\Support\Facades\Auth;

class ChatsBusiness extends Business {

    public function __construct()
    {
        parent::__construct();

        $this->repo = new ExtendedChatRepository(app());
    }    

    // Get Amount of Contacts in Bag
    public function getBagContactsCount(int $company_id = null): int{
        if (!$company_id) {
            $User = Auth::check() ? Auth::user() : session('logged_user');
            if ($User) {
                $company_id = $User->company_id;
            } 
            else {
                throw new Exception("getBagContacsCount needs company_id param!", 1);
            }
        }

        $count = $this->repo->model()::select('contact_id')
            ->where(['company_id' => $company_id])->distinct()->get();

        return $count->count();
    }    

}
