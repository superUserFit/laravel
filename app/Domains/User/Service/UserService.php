<?php

namespace App\Domains\User\Service;

use App\Common\Service\BaseService;
use App\Domains\User\Repository\UserRepository;
use App\Domains\User\Model\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;


class UserService extends BaseService {
    private UserRepository $userRepository;


    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }


    public function findById(string $model, $id)
    {
        return $this->findById($model, $id);
    }


    public function login(array $data) {
        if(!Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
            throw new UnauthorizedException('Invalid username or password', 401);
        }

        $UserID = Auth::user()->id;
        $User = $this->findById(User::class, $UserID);

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
}