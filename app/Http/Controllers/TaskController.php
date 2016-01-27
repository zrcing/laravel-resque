<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * The TaskRepository instance
     * 
     * @var App\Repositories\TaskRepository
     */
    protected $taskGestion;
    
    public function __construct(TaskRepository $taskGestion)
    {
        $this->taskGestion = $taskGestion;
    }
    
    public function monitoring()
    {
        //print_r(auth()->user());
        $page = 2;
        $tasks = Task::query()->paginate($page);
        $links = $tasks->render();
        
        return view('front.task.monitoring', compact('tasks', 'links'));
    }
    
    public function store(Request $request)
    {
        $a = $request->all();
        print_r($a);
    }
}