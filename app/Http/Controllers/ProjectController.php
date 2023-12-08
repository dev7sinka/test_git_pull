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
    public function register(Request $request)
    {
        $create_project = $this->projectService->create($request->all());
        if ($create_project == false) {
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
        $project = $this->projectService->findById($request->project_id);

        if ($project->status == ProjectStatusEnum::OFF->value) {
            return response()->json();
        }

        // Headers for Server-Sent Events
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        // Flushes the buffer, enabling real-time output
        ob_end_clean();
        ini_set('implicit_flush', 1);
        ob_implicit_flush(1);

        $path_project = $project->link_folder;

        // Run the git pull command and handle each line of output
        $handle = popen("cd $path_project && git pull 2>&1", 'r');
        if ($handle) {
            while (!feof($handle)) {
                $buffer = fgets($handle);
                echo "data: $buffer\n\n";
                flush(); // Flush the output to the browser.
            }
            pclose($handle);
        }

        return response()->noContent();
    }

    /**
     * get detail project by id
     */
    public function detail(Request $request)
    {
        $project = $this->projectService->findById($request->project_id);
        if (!$project) {
            return response()->json(['error' => 'không có project']);
        }
        return response()->json(['project' => $project]);
    }

    /**
     * edit project
     */
    public function editProject(Request $request)
    {
        $edit_project = $this->projectService->edit($request->all());
        if ($edit_project == false) {
            Session::flash('error', "edit project thất bại!");
            return redirect()->route('project.index');
        }
        Session::flash('success', "edit project thành công!");
        return redirect()->route('project.index');
    }

}
