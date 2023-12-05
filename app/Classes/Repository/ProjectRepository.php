<?php

namespace App\Classes\Repository;

use App\Classes\Repository\Interfaces\IProjectRepository;
use App\Models\Projects;

class ProjectRepository extends BaseRepository implements IProjectRepository
{
    public function __construct(Projects $model)
    {
        parent::__construct($model);
    }


}
