<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\User\UserServices;


class UserController extends Controller
{
    protected $userService;
    public function __construct(UserServices $userServices) {
        $this->userService = $userServices;
    }

    public function index()
    {
        $users = $this->userService->getAllUser();
        $roles = $this->userService->getUserRoles();
        
        return view('admin.user.index', compact('users','roles'));
    }

    public function store(UserRequest $request)
    {
        
        $this->userService->createUser($request->validated());
        return redirect()->route('user.index')->with('message', 'Berhasil membuat User');
    }
}
