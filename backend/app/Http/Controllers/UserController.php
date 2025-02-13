<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register( UserRegisterRequest $request ) {

        $request->validated();

        $user = User::create([

            "name" => $request["name"],
            "email" => $request["email"],
            "password" => bcrypt( $request["password"]),
            "city_id" => ( new CityController )->getCityId( $request[ "city" ]),
            "admin" => $request[ "admin" ]
        ]);

        return $this->sendResponse( $user->name, "Sikeres regisztráció");
    }
}
