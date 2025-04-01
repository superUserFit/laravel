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
    public function index()
    {
        $Users = User::all()->toArray();

        return response()->json($Users);
    }

    public function login(Request $request)
    {
        $data = $request->all();
        $user = $this->userService->login($data);

        return response()->json([
            'message' => 'Login Successful',
            'data' => $user
        ]);
    }


    public function register(Request $request)
    {
        $data = $request->all();
        $User = $this->userService->create(User::class, $data);

        return response()->json([
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
        $User = User::findOrFail($id);
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
