<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        $company = new Company();
        $company->name = $request->get('name');

        //TODO mechanism to upload an image/logo and set directory url as value
        //$company->logo = '';

        $company->save();

        //TODO move this to its proper location, can be in the company created observer or in UserController
        //Do this when implementing user auth
        $user = new User();
        $user->company_id = $company->id;
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->save();
    }
}
