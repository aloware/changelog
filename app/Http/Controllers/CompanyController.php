<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Http\Traits\CreatesCompany;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    use CreatesCompany;

    public function store(CompanyStoreRequest $request)
    {
        $company = $this->addCompany($request->validated());

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
