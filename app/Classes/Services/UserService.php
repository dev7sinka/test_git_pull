<?php

namespace App\Classes\Services;

use App\Classes\Repository\Interfaces\IUserRepository;
use App\Classes\Services\Interfaces\IUserService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Implement UserService
 */
class UserService extends BaseService implements IUserService
{
    private $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

}
