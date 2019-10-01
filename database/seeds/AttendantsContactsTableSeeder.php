<?php

use App\Models\AttendantsContact;
use Illuminate\Database\Seeder;

class AttendantsContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Truncate AttendantsContacts Table...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('attendants_contacts')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Creating AttendantsContacts relations:');
        AttendantsContact::create([
            'id' => 1,
            'attendant_id' => 3,
            'contact_id' => 1,
        ]);
        $this->command->info('AttendantContact rel Attendant 3 x Contact 1');
        AttendantsContact::create([
            'id' => 2,
            'attendant_id' => 4,
            'contact_id' => 1,
        ]);
        $this->command->info('AttendantContact rel Attendant 4 x Contact 1');
        AttendantsContact::create([
            'id' => 3,
            'attendant_id' => 3,
            'contact_id' => 2,
        ]);
        $this->command->info('AttendantContact rel Attendant 3 x Contact 2');
    }
}
