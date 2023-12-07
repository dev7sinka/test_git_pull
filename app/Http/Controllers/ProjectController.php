<?php

namespace App\Http\Controllers;

use App\Classes\Enum\ProjectStatusEnum;
use App\Classes\Services\Interfaces\IProjectService;
use App\Http\Requests\ProjectRequest;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProjectController extends Controller
{
    private $projectService;

    public function __construct(IProjectService $projectService)
    {
        $this->projectService = $projectService;
    }


    /**
     * get blade project view
     */
    public function index()
    {
        $statusProject = $this->getStatus();
        $projects = $this->projectService->getProjects();
        return view('pages.project.index', compact('statusProject','projects'));
    }

    /**
     * save data new project
     */
    public function register(ProjectRequest $request)
    {
        $create_project = $this->projectService->create($request->all());
        if (!$create_project == false) {
            Session::flash('error', "Tạo project thất bại!");
            return redirect()->route('project.index');
        }
        Session::flash('success', "Tạo project thành công!");
        return redirect()->route('project.index');
    }

    /**
     * Get status default in project
     */
    public function getStatus(): array
    {
        $statusValues = [];
        $statusCases = ProjectStatusEnum::cases();
        foreach ($statusCases as $status) {
            $statusValues[] = [
                'value' => $status->value,
                'name' => ProjectStatusEnum::getLabel($status->value)
            ];
        }
        return $statusValues;
    }

    public function gitPull(Request $request)
    {
        // $username = 'dev.sinka@gmail.com';
        // $password = 'Sinkavn@#1';
        // $link_repository = 'https://github.com/Sinka-Vietnam/solar_material_wholesale_management.git';

        // $repository = 'https://'.$username.':'.$password.'@github.com:Sinka-Vietnam/solar_material_wholesale_management.git';


        $project = $this->projectService->findById($request->project_id);

        if ($project->status == ProjectStatusEnum::OFF->value) {
            return response()->json();
        }

        $path_project = $project->link_folder;
        $output = shell_exec("cd $path_project && git pull 2>&1");

        if (strpos(strtolower($output), 'error') !== false) {
            return response()->json(['error' => $output], 500);
        }

        return response()->json(['text' => $output]);
    }


}
