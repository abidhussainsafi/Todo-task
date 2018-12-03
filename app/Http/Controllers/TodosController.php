<?php

namespace App\Http\Controllers;

use App\Todo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TodosController extends Controller
{
    
	public function index(Request $request){
		
		$user_id = Auth::user()->id;
		// dd($user_id);
		
		$my_todos = Todo::where('user_id', $user_id)->get();
		
		$data = [
			'title' => 'My ToDos',
			'todos' => $my_todos
		];
		
		return view('todos.todo_list', $data);
	}
	
	
	/**
	 * store a new todo
	 * @param Request $request
	 */
	public function store(Request $request){
		
		$inputs = [
			'user_id' => Auth::user()->id,
			'todo' => $request->get('todo')
		];
		
		if(Todo::create($inputs)){
			Session::flash('success', 'New ToDo has been added to your list');
			return redirect(route('home'));
		}else{
			Session::flash('danger', 'Something went wrong while creating your ToDo, please try agian');
			return redirect(route('home'));
		}
	}
	
	
	
	public function update(Request $request){
		$user_id = Auth::user()->id;
		$todo_id = $request->get('todo_id');
		
		$todo = Todo::where([
			['user_id', '=', $user_id],
			['id', '=', $todo_id]
		])->get();
		
		if($todo->count() == 0){
			Session::flash('danger', 'Something went wrong, please try agian');
			return redirect(route('home'));
		}
		
		if($todo[0]->fill(['todo' => $request->get('todo')])->save()){
			Session::flash('success', 'Todo has been updated successfully');
			return redirect(route('home'));
		}else{
			Session::flash('danger', 'Something went wrong, please try later');
			return redirect(route('home'));
		}
	}
	
	
	public function complete(Request $request, $id){
		
		$user_id = Auth::user()->id;
		
		$todo = Todo::where([
			['user_id', '=', $user_id],
			['id', '=', $id]
		])->get();
		
		if($todo->count() == 0){
			Session::flash('danger', 'Something went wrong, please try agian');
			return redirect(route('home'));
		}
		
		if($todo[0]->fill(['complete_status' => 'Completed', 'completed_at' => Carbon::now()])->save()){
			Session::flash('success', 'Todo has been complete successfully');
			return redirect(route('home'));
		}else{
			Session::flash('danger', 'Something went wrong, please try later');
			return redirect(route('home'));
		}
		
	}
	
	
	public function revert(Request $request, $id){
		$user_id = Auth::user()->id;
		
		$todo = Todo::where([
			['user_id', '=', $user_id],
			['id', '=', $id]
		])->get();
		
		if($todo->count() == 0){
			Session::flash('danger', 'Something went wrong, please try agian');
			return redirect(route('home'));
		}
		
		if($todo[0]->fill(['complete_status' => 'Pending', 'completed_at' => NULL])->save()){
			Session::flash('success', 'Todo status has been reverted successfully');
			return redirect(route('home'));
		}else{
			Session::flash('danger', 'Something went wrong, please try later');
			return redirect(route('home'));
		}
	}
	
	
	public function destroy(Request $request){
		$user_id = Auth::user()->id;
		
		$todo = Todo::where([
			['user_id', '=', $user_id],
			['id', '=', $request->get('todo_del_id')]
		])->get();
		
		if($todo->count() == 0){
			Session::flash('danger', 'Something went wrong, please try agian');
			return redirect(route('home'));
		}
		
		if($todo[0]->delete()){
			Session::flash('success', 'Todo has been deleted successfully');
			return redirect(route('home'));
		}else{
			Session::flash('danger', 'Something went wrong, please try later');
			return redirect(route('home'));
		}
	}
}
