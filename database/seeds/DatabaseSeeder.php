<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CompaniesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(StatusTableSeeder::class);
        $this->call(MessagesTypesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ContactsTableSeeder::class);
        $this->call(AttendantsContactsTableSeeder::class);
        $this->call(SocialnetworksTableSeeder::class);
        $this->call(ChatsTableSeeder::class);
        $this->call(ChatsTestsTableSeeder::class);
        $this->call(RpisTableSeeder::class);
    }
}
