<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Repository\CompanyRepository;
use App\Models\Company;
use App\Models\User;
use Spatie\Permission\Models\Role;

class CompanyController extends Controller
{
   
    private $companyRepository;
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->middleware('auth');
        $this->companyRepository = $companyRepository;
    }

    private function find_company ($id){
       return $company = Company::find($id);
    }

    public function index()
    {
        $companies = Company::all();

        return view('admin.company.list', compact('companies'));
    }

    public function create()
    {
        $roles =  Role::all();
        return view('admin.company.add', compact('roles'));
    }

    public function store(CompanyRequest $request)
    {
        return $response = $this->companyRepository->postCompany($request);
    }

    
    public function show($id)
    {
        $company = $this->find_company($id);
        return view('admin.company.view',compact('company'));
    }

    
    public function edit($id)
    {
        $company = $this->find_company($id);
        return view('admin.company.edit',compact('company'));
    }

    
    public function update(CompanyUpdateRequest $request, $id)
    {
        return $response = $this->companyRepository->updateCompany($request);
    }

    public function deactivate($id)
    {
        return $response = $this->companyRepository->deactivateCompany();
    }

    public function activate($id)
    {
        return $response = $this->companyRepository->activateCompany();
    }

    public function users_company($id)
    {
        $users_company = User::where('company_id',$id)->where('user_type',User::COMPANY)->get();
        $company = $this->find_company($id);
        return view('admin.company.users.list', compact('users_company','company'));
    }

    public function customers_company($id)
    {
        $customers_company = User::where('company_id',$id)->where('user_type',User::CUSTOMER)->get();
        $company = $this->find_company($id);
        return view('admin.company.users.customers', compact('customers_company','company'));
    }
}
