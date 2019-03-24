<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', ['tasks' => $tasks, 'action'=>'index']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuarios = User::all()->pluck('username', 'id');
        return view('tasks.create',[
            'usuarios' => $usuarios,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $taskRequest)
    {
        $data = $taskRequest->all();

        $creada = Task::create($data);
        if ($creada)
        {
           // $this->enviar($despachoRequest->archivo);
            Session::flash('message-success', 'Tarea guardada satisfactoriamente.');
            return redirect()->route('task.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $usuarios = User::all()->pluck('username', 'id');
        return view('tasks.edit', [
            'task' => $task,
            'usuarios' => $usuarios,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $data = $request->all();
        if (!isset($data['activa']))
            $data['activa'] = 'NO';

        $task->fill($data)->update();
        Session::flash('message-success', 'Tarea actualizada satisfactoriamente.');
        return redirect()->route('task.index');
    }

    public function eliminated()
    {
        $tasksEliminados = Task::onlyTrashed()->get();
        return view('tasks.eliminated', ['tasks' => $tasksEliminados, 'action' => 'restore']);
    }

    public function restore($id)
    {
        $task = Task::withTrashed()->where('slug', '=', $id)->first();
        $task->restore();
        Session::flash('message-success', 'Tarea restaurada satisfactoriamente.');
        return redirect()->route('task.index');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        Session::flash('message-danger', 'Tarea eliminada satisfactoriamente.');
        return redirect()->route('task.index');
    }
}
