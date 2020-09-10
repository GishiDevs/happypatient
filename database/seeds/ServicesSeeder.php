<?php

use Illuminate\Database\Seeder;
use App\Service;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            'Ultrasound',
            'E.C.G',
            'Check-up',
            'Laboratory',
            'Physical Therapy',
            'X-Ray',
         ];
 
 
         foreach ($services as $service) {
              Service::create(['service' => $service, 'status' => 'active']);
         }
    }
}
