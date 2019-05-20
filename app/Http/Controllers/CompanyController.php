<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Company;
use \App\User;

class CompanyController extends Controller
{
    public function create(Request $request)
    {
        $name = $request->input('CompanyName');
        if (empty($name)) {
            return response()->json(['success' => false, 'error' => 'Company name can\'t be empty']);
        }
        $company = new Company([
            'CompanyName' => $name,
        ]);
        if ($company->save() === false) {
            return response()->json(['success' => false, 'error' => 'Unable to save company']);
        }
        return response()->json(['success' => true, 'result' => [
            'CompanyId' => $company->CompanyID,
            'CompanyName' => $company->CompanyName,
        ]]);
    }

    public function delete(Request $request, int $id)
    {
        $company = Company::where(['CompanyID' => $id])->first();
        if (empty($company)) {
            return response()->json(['success' => false, 'error' => 'Company not found']);
        }
        if ($company->delete() === false) {
            return response()->json(['success' => false, 'error' => 'Unable to save company']);
        }
        return response()->json(['success' => true]);
    }

    public function update(Request $request, int $id)
    {
        $company = Company::where(['CompanyID' => $id])->first();
        if (empty($company)) {
            return response()->json(['success' => false, 'error' => 'Company not found']);
        }
        $name = $request->input('CompanyName');
        if (empty($name)) {
            return response()->json(['success' => false, 'error' => 'Company name can\'t be empty']);
        }
        $company->CompanyName = $name;
        if ($company->save() === false) {
            return response()->json(['success' => false, 'error' => 'Unable to save company']);
        }
        return response()->json(['success' => true, 'result' => [
            'CompanyId' => $company->CompanyID,
            'CompanyName' => $company->CompanyName,
        ]]);
    }

    public function get(int $id)
    {
        $company = Company::where(['CompanyID' => $id])->first();
        if (empty($company)) {
            return response()->json(['success' => false, 'error' => 'Company not found']);
        }
        return response()->json(['success' => true, 'result' => [
            'CompanyId' => $company->CompanyID,
            'CompanyName' => $company->CompanyName,
        ]]);
    }

    public function index()
    {
        $cur = Company::all();
        $res = [];
        foreach ($cur as $rec) {
            $res[] = ['CompanyID' => $rec->CompanyID, 'CompanyName' => $rec->CompanyName];
        }
        return response()->json(['success' => true, 'result' => $res]);
    }

    public function getusers(int $id)
    {
        $company = Company::where(['CompanyID' => $id])->first();
        if (empty($company)) {
            return response()->json(['success' => false, 'error' => 'Company not found']);
        }
        $res = [];
        foreach ($company->users as $rec) {
            $res[] = ['UserID' => $rec->UserID, 'UserName' => $rec->UserName];
        }
        return response()->json(['success' => true, 'result' => $res]);
    }

    public function adduser(int $id, int $uid)
    {
        $company = Company::where(['CompanyID' => $id])->first();
        if (empty($company)) {
            return response()->json(['success' => false, 'error' => 'Company not found']);
        }
        $user = User::where(['UserID' => $uid])->first();
        if (empty($user)) {
            return response()->json(['success' => false, 'error' => 'User not found']);
        }
        $company->users()->attach($user);
        return response()->json(['success' => true]);
    }

    public function removeuser(int $id, int $uid)
    {
        $company = Company::where(['CompanyID' => $id])->first();
        if (empty($company)) {
            return response()->json(['success' => false, 'error' => 'Company not found']);
        }
        $user = User::where(['UserID' => $uid])->first();
        if (empty($user)) {
            return response()->json(['success' => false, 'error' => 'User not found']);
        }
        $company->users()->detach($user);
        return response()->json(['success' => true]);
    }
}
