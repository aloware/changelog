<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Traits\CreatesProject;
use App\Http\Traits\StoresChangelog;
use App\Http\Traits\CreatesCompany;
use App\Models\Category;
use App\Models\Project;
use App\Models\Changelog;
use App\Models\Company;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use CreatesCompany;
    use CreatesProject;
    use StoresChangelog;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

            'name' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // TODO refactor this block, find a better and efficient way to handle multiple model creations on user registration
        $company = $this->addCompany($data);

        $user = new User();
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->company_id = $company->id;
        $user->save();

        $this->addProject($data, $company->id, $user->id);

        $categories = [
            [
                'label' => 'New',
                'company_id' => $company->id,
                'bg_color' => '#007bff',
                'text_color' => '#fff'
            ],
            [
                'label' => 'Improvement',
                'company_id' => $company->id,
                'bg_color' => '#28a745',
                'text_color' => '#fff'
            ],
            [
                'label' => 'Fix',
                'company_id' => $company->id,
                'bg_color' => '#ffc107',
                'text_color' => '#fff'
            ]
        ];

        DB::table('categories')->insert($categories);
        return $user;
    }
}
