<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

Route::get('/pull', function () {

    $process = new Process(['git', 'pull']);
    $process->setTimeout(null);
    $process->run();

    if (!$process->isSuccessful()) {
        throw new ProcessFailedException($process);
    }

    return 'Git pull successful';
});

Route::get('/git-command', function () {
    $commands = [
        'git status', // Example Git command: git status
        'git log',    // Another Git command: git log
        // Add more Git commands or other shell commands here
        'git branch',
    ];

    $output = '';

    foreach ($commands as $command) {
        $process = Process::fromShellCommandline($command);
        $process->setTimeout(null);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output .= '<p>Command: ' . $command . '</p>';
        $output .= '<pre>' . $process->getOutput() . '</pre>';
    }

    return $output;
});

Route::get('test', [Controller::class, 'pdf']);
