<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function view()
    {
        if(auth()->user())
        {
            $user = auth()->user();
            $tasks = Task::where('user_id', $user->id)->get();
        }

        return view('dashboard', auth()->user() ? ['tasks' => $tasks] : ['']);
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
            'name' => 'required'
        ],
        [
            'required' => 'O campo acima é obrigatório.'
        ]);



        if($validator->fails())
        {
            return redirect('#modal#add')->withErrors($validator);
        }

        

        $create = Task::create([
            'name' => $request->name,
            'user_id' => auth()->user()->id,
        ]);

        if($create)
        {
            return redirect()->back()->with('mgs-success', 'Tarefa adicionada com sucesso.');
        }

        return redirect()->back()->with('mgs-error', 'Erro ao tentar adicionar nova tarefa.');
    }



    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), 
        [
            'name#' . $id  => 'required'
        ],
        [
            'required' => 'O campo acima é obrigatório.'
        ]);

        if($validator->fails())
        {
            return redirect('/tasks#modal#edit#' . $id)->withErrors($validator);
        }



        $update = Task::findOrFail($id)->update([
            'name' => $request->input('name#' . $id)
        ]);

        if($update)
        {
            return redirect()->back()->with('mgs-success', 'Tarefa editada com sucesso.');
        }

        return redirect()->back()->with('mgs-error', 'Erro ao tentar editar tarefa.');
    }



    public function destroy(string $id)
    {
        $destroy = Task::findOrFail($id)->delete();
        if($destroy)
        {
            return redirect()->back()->with('mgs-success', 'Tarefa excluída com sucesso.');
        }

        return redirect()->back()->with('mgs-error', 'Erro ao tentar excluir tarefa.');
    }



    public function toTodo(string $id)
    {
        $task = Task::findOrFail($id);

        $update = Task::findOrFail($id)->update([
            'name' => $task->name,
            'status' => 'to_do'
        ]);

        if($update)
        {
            return redirect()->back()->with('mgs-success', 'Tarefa editada com sucesso.');
        }

        return redirect()->back()->with('mgs-error', 'Erro ao tentar editar tarefa.');
    }

    public function toDoing(string $id)
    {
        $task = Task::findOrFail($id);

        $update = Task::findOrFail($id)->update([
            'name' => $task->name,
            'status' => 'doing'
        ]);

        if($update)
        {
            return redirect()->back()->with('mgs-success', 'Tarefa editada com sucesso.');
        }

        return redirect()->back()->with('mgs-error', 'Erro ao tentar editar tarefa.');
    }

    public function toDone(string $id)
    {
        $task = Task::findOrFail($id);
        
        $update = Task::findOrFail($id)->update([
            'name' => $task->name,
            'status' => 'done'
        ]);

        if($update)
        {
            return redirect()->back()->with('mgs-success', 'Tarefa editada com sucesso.');
        }

        return redirect()->back()->with('mgs-error', 'Erro ao tentar editar tarefa.');
    }
}
