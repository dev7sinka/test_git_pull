<?php

namespace App\Http\Controllers;

use App\Classes\Enum\ProjectStatusEnum;
use App\Classes\Services\Interfaces\IProjectService;
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
    public function register(Request $request)
    {
        // if (!$create == false) {
            Session::flash('error', "rẻtrtewtr!");
            return redirect()->route('project.index');
        // }
        // Session::flash('success', "プロファイルを正常に編集しました!");
        // $create_project = $this->projectService->create($request->all());
        // return redirect()->route('project.index');
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

    public function pull()
    {
        // $username = 'dev.sinka@gmail.com';
        // $password = 'Sinkavn@#1';
        // $link_repository = 'https://github.com/Sinka-Vietnam/solar_material_wholesale_management.git';

        // $repository = 'https://'.$username.':'.$password.'@github.com:Sinka-Vietnam/solar_material_wholesale_management.git';

        $path_project = 'C:\\laragon\\www\\solar_material_wholesale_management';
        $output = shell_exec("cd $path_project && git pull 2>&1");

        if (strpos(strtolower($output), 'error') !== false) {
            return response()->json(['error' => $output], 500);
        }

        return response()->json(['result' => $output]);
    }


}
