<?php
use App\Models\Status;
use Illuminate\Database\Seeder;

class GeralStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Truncate Status Tables (status)...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('status')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->CreateTrackingStatus();
    }

    function CreateTrackingStatus() {
        $this->command->info('Creating Users Status:');

        Status::create([
            'id' => '1',
            'name' => 'POSTED',
            'model' => 'App\Models\Status',
            'description' => 'Object POSTED',
        ]);
        $this->command->info('Tracking Status POSTED');
        
        Status::create([
            'id' => '2',
            'name' => 'MOVING',
            'model' => 'App\Models\Status',
            'description' => 'Object MOVING',
        ]);
        $this->command->info('Tracking Status MOVING');
        
        Status::create([
            'id' => '3',
            'name' => 'STOPPED',
            'model' => 'App\Models\Status',
            'description' => 'Object STOPPED',
        ]);
        $this->command->info('Tracking Status STOPPED');
        
        Status::create([
            'id' => '4',
            'name' => 'RECEIVED',
            'model' => 'App\Models\Status',
            'description' => 'Object RECEIVED',
        ]);
        $this->command->info('Tracking Status RECEIVED');

        Status::create([
            'id' => '5',
            'name' => 'ARRIVED',
            'model' => 'App\Models\Status',
            'description' => 'Object ARRIVED',
        ]);
        $this->command->info('Tracking Status ARRIVED');
        
    }

}