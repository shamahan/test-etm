<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use \App\Company;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $company = null;
        if (!$request->filled('UserName')) {
            return response()->json(['success' => false, 'error' => 'User name can\'t be empty']);
        }
        if ($request->filled('CompanyID')) {
            $company = Company::where(['CompanyID' => intval($request->input('CompanyID'))])->first();
            if (empty($company)) { 
                return response()->json(['success' => false, 'error' => 'Invalid CompanyID']);
            }
        }
        $user = new User([
            'UserName' => $request->input('UserName'),
        ]);
        if ($user->save() === false) {
            return response()->json(['success' => false, 'error' => 'Unable to save user']);
        }        
        if (!empty($company)) {
            $user->companies()->attach($company);
        }
        return response()->json(['success' => true, 'result' => [
            'UserId' => $user->UserID,
            'UserName' => $user->UserName,
        ]]);
    }

    public function delete(Request $request, int $id)
    {
        $user = User::where(['UserID' => $id])->first();
        if (empty($user)) {
            return response()->json(['success' => false, 'error' => 'User not found']);
        }
        if ($user->delete() === false) {
            return response()->json(['success' => false, 'error' => 'Unable to save user']);
        }
        return response()->json(['success' => true]);
    }

    public function update(Request $request, int $id)
    {
        $user = User::where(['UserID' => $id])->first();
        if (empty($user)) {
            return response()->json(['success' => false, 'error' => 'User not found']);
        }
        $name = $request->input('UserName');
        if (empty($name)) {
            return response()->json(['success' => false, 'error' => 'User name can\'t be empty']);
        }
        $user->UserName = $name;
        if ($user->save() === false) {
            return response()->json(['success' => false, 'error' => 'Unable to save user']);
        }
        return response()->json(['success' => true, 'result' => [
            'UserId' => $user->UserID,
            'UserName' => $user->UserName,
        ]]);
    }

    public function get(int $id)
    {
        $user = User::where(['UserID' => $id])->first();
        if (empty($user)) {
            return response()->json(['success' => false, 'error' => 'User not found']);
        }
        return response()->json(['success' => true, 'result' => [
            'UserId' => $user->UserID,
            'UserName' => $user->UserName,
        ]]);
    }

    public function index()
    {
        $cur = User::all();
        $res = [];
        foreach ($cur as $rec) {
            $res[] = ['UserID' => $rec->UserID, 'UserName' => $rec->UserName];
        }
        return response()->json(['success' => true, 'result' => $res]);
    }


    public function getcompanies(int $id)
    {
        $user = User::where(['UserID' => $id])->first();
        if (empty($user)) {
            return response()->json(['success' => false, 'error' => 'User not found']);
        }
        $res = [];
        foreach ($user->companies as $rec) {
            $res[] = ['CompanyID' => $rec->CompanyID, 'CompanyName' => $rec->CompanyName];
        }
        return response()->json(['success' => true, 'result' => $res]);
    }
}
