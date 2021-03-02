<?php


namespace App\Http\Traits;


use App\Models\Company;

trait CreatesCompany
{
    public function addCompany(array $data): Company
    {
        $company = new Company();
        $company->name = $data['name'];
        $company->save();

        return $company;
    }
}
