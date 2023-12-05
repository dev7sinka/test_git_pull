<?php

namespace App\Classes\Repository;

use App\Classes\Repository\Interfaces\IUserRepository;
use App\Models\User;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }


}
