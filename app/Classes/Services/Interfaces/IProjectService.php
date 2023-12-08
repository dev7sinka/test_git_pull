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

    /**
     * find project by id
     * @param int $project_id
     */
    public function findById($id);


    /**
     * edit project
     * @param array $data
     */
    public function edit($data);
}
