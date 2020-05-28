<?php

namespace Tests\Unit\App\Controllers\Extended;

use App\Models\Company;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tests\MyTestCase;

class ExtendedCompanyControllerTest extends MyTestCase
{

    public function testRouteCompaniesReturnsOneOrMoreCompaniesForSeller()
    {
        $Admin_id = 1;

        $Admin = User::find($Admin_id);

        Auth::login($Admin);

        $response = $this->be($Admin)->get('/companies');
        $responseContent = $response->getContent();
        $companies = json_decode($responseContent);

        $response->assertSuccessful();
        $this->assertJson($responseContent);
        $this->assertGreaterThanOrEqual(1, count($companies));
    }

    public function testRouteCompaniesGetNullForNormalUser()
    {
        $User_id = 4;

        $User = User::find($User_id);

        Auth::login($User);

        $response = $this->be($User)->get('/companies');
        $responseContent = $response->getContent();
        $companies = json_decode($responseContent);

        $response->assertSuccessful();
        $this->assertEmpty($responseContent);
    }

    public function testRoutePostCompanyReturnsCreatedCompany()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock Into DB Test
        $Company = new Company();
        $Company->name = 'Test company';
        $Company->email = 'alberto@company.test';
        $Company->CNPJ = 'CNPJ';
        $Company->rpi_id = 1;

        $response = $this->be($Manager)->post('/companies', $Company->toArray());
        $response->assertSuccessful();
        $responseContent = $response->getContent();
        
        $responseCompany = json_decode($responseContent);
        if ($Company = Company::find($responseCompany->id)) { // Delete created user
            $Company->delete();
        }
        $this->assertJson($responseContent);
        $this->assertEquals($Company->name, $responseCompany->name); // Expected to be the next to be inserted  
        $this->assertEquals($Company->email, $responseCompany->email);
        $this->assertEquals($Company->CNPJ, $responseCompany->CNPJ);
        $this->assertEquals($Company->rpi_id, $responseCompany->rpi_id);

    }    

    public function testRoutePutCompanyReturnsUpdatedCompany()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock Into DB Test
        if ($Company = Company::find(100)) { // Delete created user
            $Company->delete();
        }
        $Company = new Company();
        $Company->id = 100;
        $Company->name = 'Test company';
        $Company->email = 'alberto@company.test';
        $Company->CNPJ = 'CNPJ';
        $Company->rpi_id = 1;
        $Company->save();
        
        $CompanyArray = $Company->toArray();
        $CompanyArray['id'] = 100;
        $CompanyArray['name'] = 'Test company new';
        $CompanyArray['email'] = 'alberto@company.test.new';
        $CompanyArray['CNPJ'] = 'newCNPJ';
        $CompanyArray['rpi_id'] = null;
        
        $response = $this->be($Manager)->put("/companies/".$CompanyArray['id'], $CompanyArray);
        $response->assertSuccessful();
        $responseContent = $response->getContent();
        $responseCompany = json_decode($responseContent);
        $Company->delete();

        $this->assertJson($responseContent);
        $this->assertEquals($CompanyArray['id'], $responseCompany->id); // Expected to be the next to be inserted  
        $this->assertEquals($CompanyArray['name'], $responseCompany->name);
        $this->assertEquals($CompanyArray['email'], $responseCompany->email);
        $this->assertEquals($CompanyArray['CNPJ'], $responseCompany->CNPJ);
        $this->assertEquals($CompanyArray['rpi_id'], $responseCompany->rpi_id);
    }

    public function testRouteDestroyCompanyReturnsEmptyAfterDelete()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock Into DB Test
        if ($Company = Company::find(100)) { // Delete created user
            $Company->delete();
        }
        $Company = new Company();
        $Company->id = 100;
        $Company->name = 'Test company';
        $Company->email = 'alberto@company.test';
        $Company->CNPJ = 'CNPJ';
        $Company->rpi_id = 1;
        $Company->save();

        $response = $this->be($Manager)->delete("/companies/$Company->id");

        $responseContent = $response->getContent();

        $response->assertSuccessful();
        $this->assertEmpty($responseContent);
        $this->assertNull(Company::find($Company->id));
    }

}
