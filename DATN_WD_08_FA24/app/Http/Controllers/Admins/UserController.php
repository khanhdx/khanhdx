<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $userService;
    public function __construct() {

    }
    public function index(Request $request)
    {
        //
        $result = ['status' => 200];
        $us = $request->input();
        foreach ($us as $key => $value) {
            $role = $key;
        }
        if($role === "KaHNcsHAfg1") {
            try {
                $result['data'] = (new UserService())->getAll();
            } catch (Exception $e) {
                $result = [
                    'status'=>500,
                    'error'=>$e->getMessage(),
                ];
            }
            return view('admins.accounts.users.index',$result);
        }        
        else if($role == "NvNhaEAeiN2") {
            return view('admins.accounts.personnels.index');
        }
        else {
            echo "error not fount";
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $r = $request->query();
        foreach ($r as $key => $value) {
            $role = $key;
        }
        if($role === "KaHNcsHAfg1") {
            return view('admins.accounts.users.create');
        }        
        else if($role == "NvNhaEAeiN2") {
            return view('admins.accounts.personnels.create');
        }
        else {
            echo "error not fount";
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Lấy dữ liệu người dùng
        $user = $request->input('user');
        $locations = $request->input('location');
        $status_location = $request->input('status');
        dd($locations,$user,$status_location);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
