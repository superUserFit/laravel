<?php

namespace App\Domains\User\Controller;

use App\Domains\User\Service\UserService;
use Illuminate\Http\Request;

use App\Domains\User\Model\User;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $data = $this->userService->getIndex($params);

        return $this->response($data);
    }

    public function login(Request $request)
    {
        $data = $request->all();
        $user = $this->userService->login($data);

        return $this->response([
            'message' => 'Login Successful',
            'data' => $user
        ]);
    }


    public function register(Request $request)
    {
        $data = $request->all();
        $User = $this->userService->register($data);

        return $this->response([
            'message' => 'Success',
            'data' => $User
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $User = $this->userService->getUser($id);
        return response()->json([
            'data' => $User
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
