<?php

namespace App\Classes\Services;

use App\Classes\Repository\Interfaces\IProjectRepository;
use App\Classes\Services\Interfaces\IProjectService;
use Gitonomy\Git\Commit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Implement UserService
 */
class ProjectService extends BaseService implements IProjectService
{
    private $projectRepository;

    public function __construct(IProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @inheritDoc
     */
    public function getProjects()
    {
        return $this->projectRepository->find([]);
    }

    /**
     * @inheritDoc
     */
    public function create($data)
    {
        DB::beginTransaction();
        try {
            $attr = [
                'status' => $data['status'],
                'name' => $data['name'],
                'link_folder' => $data['link_folder'],
                'memo' => $data['memo']
            ];

            $this->projectRepository->create($attr);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error create new project: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function findById($id)
    {
        return $this->projectRepository->findById($id);
    }

    /**
     * @inheritDoc
     */
    public function edit($data)
    {
        DB::beginTransaction();
        try {
            $project = $this->projectRepository->findById($data['id']);
            $attr = [
                'status' => $data['edit_status'],
                'name' => $data['edit_name_project'],
                'link_folder' => $data['edit_link_folder'],
                'memo' => $data['edit_memo']
            ];

            $this->projectRepository->update($project, $attr);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error edit new project: ' . $e->getMessage());
            return false;
        }
    }
}
