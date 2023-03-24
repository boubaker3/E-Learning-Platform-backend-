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
 
        
            DB::table('purshases')->insert(  
                ['purshaseid'=>uniqid(),
                'sellerid'=> '169058629814809',
                'userid'=>"29207029759808",
                 'courseid' => "52891353934675",
                'amount' => 20,
                'payerid' => uniqid(),
                'paymentid' => uniqid(),

                "created_at"=>date("Y-m-d H:i:s"),
                "updated_at"=>date("Y-m-d H:i:s") ]);
     
    }
}
