<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
 
        for($i=0;$i<20;$i++){
         
            DB::table('ratings')->insert(  
                ['ratingid'=>uniqid(),
                'courseid'=> '641714de6ebd7',
                'senderid'=>uniqid(),
                 'review' => "review",
                'rating' => 5,
                "created_at"=>date("Y-m-d H:i:s"),
                "updated_at"=>date("Y-m-d H:i:s") ]);

        }
       
    }
}
