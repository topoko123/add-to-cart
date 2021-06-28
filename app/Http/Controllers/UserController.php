<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use Illuminate\Support\Str;

class UserController extends Controller
{
    public function create_user(Request $request) {
        DB::beginTransaction();
        try {
            $random_id = Str::uuid()->toString();
            $data_save_to_db = array();

            $data_save_to_db["user_id"] = strtr($random_id, '-', $random_id); 
            $data_save_to_db["name"] = $request->name;  
            $data_save_to_db["email"] = $request->email;
            $data_save_to_db["password"] = $request->password;
            $data_save_to_db["created_at"] = Carbon::now('Asia/Bangkok');

            DB::table('users')->insert($data_save_to_db);
            DB::commit();
            return response()
                            ->Json(['message'=>'Create User!'])
                            ->setStatusCode(201)
                            ->header("Content-Type", "application/json");
       }
       catch (\Exception $e) {
           DB::rollBack();
           return response()
                            ->Json(['message'=>'Failed'])
                            ->setStatusCode(400)
                            ->header("Content-Type", "application/json");
            
       }
    }

}
