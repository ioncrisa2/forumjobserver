<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Location;
use App\Traits\AuthUser;

class CompanyService
{
    public function showAll()
    {
        return Company::all();
    }

    public function storeData(array $data)
    {
        $company = Company::create([
            'name'          => $data['name'],
            'description'   => $data['description'],
            'established'   => date('Y-m-d', strtotime($data['established'])),
            'website_url'   => $data['website_url'],
            'company_field' => $data['company_field']
        ]);

        $company->location()->create([
            'street_address' => $data['street_address'],
            'country'        => $data['country'],
            'state'          => $data['state'],
            'city'           => $data['city'],
            'zip_code'       => $data['zip_code'],
        ]);

        return $company;
    }

    public function showData(Int $id)
    {
        return Company::findOrFail($id);
    }

    public function updateData($id, array $data)
    {
        $company = Company::FindOrFail($id);

        $company->update([
            'name'          => $data['name'],
            'description'   => $data['description'],
            'established'   => date('Y-m-d', strtotime($data['established'])),
            'website_url'   => $data['website_url'],
            'company_field' => $data['company_field']
        ]);

        $company->location()->update([
            'street_address' => $data['street_address'],
            'country'        => $data['country'],
            'state'          => $data['state'],
            'city'           => $data['city'],
            'zip_code'       => $data['zip_code'],
        ]);

        return $company;
    }

    public function deleteData($id)
    {
        $company = Company::findOrFail($id)->first();
        $company->delete();
        $company->location->delete();
    }

    public function deleteAll()
    {
        Company::whereNotNull('id')->delete();
        Location::whereNotNull('id')->delete();
    }
}
