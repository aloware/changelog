<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $account = new Account();

        $company = Company::find($request->get('company_id'));

        if (!$company) {
            return response()->json(['status' => 'error', 'message' => 'Company not found.']);
        }
        $account->company_id = $company->id;
        $account->application_name = $request->get('application_name');
        $account->application_logo = $request->get('application_logo');
        $account->application_url = $request->get('application_url');
        $account->terminology = $request->get('terminology');
        $account->created_by = Auth::id();

        $account->save();

        return response()->json(['account' => $account]);
    }

    public function updated($id, Request $request)
    {
        $account = Account::find($id);
        $account->application_name = $request->get('application_name');
        $account->application_logo = $request->get('application_logo');
        $account->application_url = $request->get('application_url');
        $account->terminology = $request->get('terminology');

        $account->save();
    }
}
