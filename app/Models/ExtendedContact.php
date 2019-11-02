<?php

namespace App\Models;

class ExtendedContact extends Contact
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function latestAttendantContact()
    {
        return $this->hasOne(\App\Models\AttendantsContact::class, 'contact_id', 'id')->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function latestAttendant()
    {
        return $this->hasOne(\App\Models\AttendantsContact::class, 'contact_id', 'id')->latest();

        // $AttendantContact = $this->hasOne(\App\Models\AttendantsContact::class, 'contact_id', 'id')->latest();
        // dd("OK");   
        // $Attendant = $AttendantContact->get();
        // dd($Attendant);
        // dd($AttendantContact->all()->last());
        // return UsersAttendant::with('User')->find($AttendantContact->attendant_id);
    }
}
