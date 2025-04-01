<?php

namespace App\Domains\User\Service;

use App\Common\Service\BaseService;
use App\Domains\User\Repository\UserRepository;
use App\Domains\User\Model\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;


class UserService extends BaseService {
    private UserRepository $userRepository;


    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function getIndex(array $params) {
        $Users = User::select([
            'id',
            'username',
            'full_name',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ])->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'username' => $user->username,
                'full_name' => $user->full_name,
                'created_at' => $user->created_at, // Original timestamp
                'created_at_format' => Carbon::parse($user->created_at)->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s'), // Formatted
                'created_by' => $user->created_by,
                'updated_at' => $user->updated_at, // Original timestamp
                'updated_at_format' => Carbon::parse($user->updated_at)->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s'), // Formatted
                'updated_by' => $user->updated_by,
            ];
        })->toArray();

        return [
            'total' => count($Users),
            'rows' => $Users
        ];
    }


    public function login(array $data) {
        if(!Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
            throw new UnauthorizedException('Invalid username or password', 401);
        }

        $UserID = Auth::user()->id;
        $User = $this->userRepository->findById(User::class, $UserID);

        $accessToken = Str::random(20);
        $User->setAccessToken($accessToken);
        $User->save();

        $data = [
            'id' => $User->id,
            'username' => $User->username,
            'fullName' => $User->full_name,
            'accessToken' => $accessToken,
        ];

        return $data;
    }


    public function register(array $data) {
        return $this->userRepository->create(User::class, $data);
    }

    public function getUser($id)
    {
        return $this->userRepository->findById(User::class, $id);
    }
}