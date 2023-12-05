<?php

namespace App\Classes\Services\Interfaces;


interface IProjectService
{

    /**
     * get project
     */
    public function getProjects();

    /**
     * create new project
     * @param array $data
     */
    public function create($data);
}
