<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helpers;
use App\Helpers\MyException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use App\Models\User;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
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
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        try {
            if(!Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
                throw new UnauthorizedException('Invalid username or password');
            }

            $User = Auth::user();

            return response()->json([
                'message' => 'Login Successful',
                'user' => $User
            ]);
        } catch(\Exception $error) {
            return Helpers::ErrorException($error, 401);
        }
    }


    public function register(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|unique:users,username',
                'password' => 'required'
            ]);

            $data = $request->all();

            $User = new User();
            $User = Helpers::loadData($User, $data);
            $User->save();

            return response()->json([
                'message' => 'Success',
                'data' => $User->id
            ]);
        } catch(\Exception $error) {
            return Helpers::ErrorException($error, 500);
        }
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
    public function show(User $user)
    {
        //
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