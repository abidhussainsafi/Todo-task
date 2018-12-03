@extends('layouts.app')

@section('content')
    <div class="container">


        <div class="row justify-content-center">
            <div class="col-md-10">
                @if(\Illuminate\Support\Facades\Session::has('success'))
                    <div class="alert alert-success">
                        {{ \Illuminate\Support\Facades\Session::get('success') }}
                    </div>
                @endif

                @if(\Illuminate\Support\Facades\Session::has('danger'))
                    <div class="alert alert-danger">
                        {{ \Illuminate\Support\Facades\Session::get('success') }}
                    </div>
                @endif
            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        {{ $title }}
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#newTodo"
                           class="btn btn-success btn-sm float-right">New ToDo</a>
                    </div>

                    <div class="card-body">

                        @if($todos->count() > 0)

                            <table class="table table-striped">
                                @foreach($todos as $todo)
                                    <tr>
                                        <td style="width: 2%;">{{ $loop->iteration }}</td>
                                        <td style="width: 83%; @if($todo->complete_status == 'Completed') text-decoration: line-through; @endif" class="todo_desc">{{ $todo->todo }}</td>
                                        <td style="width: 20%;">

                                            @if($todo->complete_status == "Pending")
                                                <a href="{{ route('todo.complete', $todo->id) }}" class="btn btn-sm
                                            btn-success">
                                                    <i class="fa fa-check-circle"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('todo.revert', $todo->id) }}" class="btn btn-sm
                                            btn-warning">
                                                    <i class="fa fa-undo"></i>
                                                </a>
                                            @endif

                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#updateTodo" class="btn btn-sm btn-info" data-todo_id="{{ $todo->id }}">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                                <form method="POST" action="{{ route('todo.destroy') }}" style="display: inline">
                                                    <input type="hidden" name="todo_del_id" value="{{$todo->id}}">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fa
                                            fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                        </td>
                                    </tr>

                                @endforeach
                            </table>


                        @else
                            <div class="alert alert-warning">
                                <strong>Sorry!</strong> you have not added any ToDo items. <strong><a
                                            href="javascript:void(0)" data-toggle="modal" data-target="#newTodo">Click
                                        here</a></strong> to add your first ToDo
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="newTodo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form action="{{ route('todo.store') }}" method="post">

                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add a New ToDo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="email">ToDo Item:</label>
                            <textarea name="todo" id="todo" rows="10" class="form-control"
                                      placeholder="Add your ToDo item here..."></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add ToDo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- edit Modal -->
    <div class="modal fade" id="updateTodo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form action="{{ route('todo.update') }}" method="post">

                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update ToDo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="todo_id" id="e_todo_id" value>
                        <div class="form-group">
                            <label for="email">ToDo Item:</label>
                            <textarea name="todo" id="e_todo" rows="10" class="form-control"
                                      placeholder="Add your ToDo item here..."></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save ToDo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#updateTodo').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var todo_id = button.data('todo_id')

                var todo_desc = button.closest('tr').find('.todo_desc').html();

                var modal = $(this);
                modal.find('.modal-body #e_todo').text(todo_desc)
                modal.find('.modal-body #e_todo_id').val(todo_id)
            })
        });
    </script>
@endsection
