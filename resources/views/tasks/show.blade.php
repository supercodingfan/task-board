@extends ('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="list-task">
                <h4 class="list-task-title">{{ $task->title }}</h4>
                <p class="list-task-meta">{{ $task->created_at }}</p>
                <p class="list-task-category">{{ $task->category }}</p>
                <p>{{ $task->description }}</p>
                <a class="btn btn-primary" href="/tasks/{{ $task->id }}/edit">Edit</a>
                {{ Form::open(['method' => 'DELETE', 'route' => ['task.destroy', $task->id]]) }}
                    {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="bids">
                <ul class="list-group">
                    @foreach($task->bids as $bid)
                        <li class="list-group-item">
                            <strong>
                                {{ $bid->created_at->diffForHumans() }}: &nbsp;
                            </strong>
                            {{$bid->user_id}} ({{ $bid->price }})
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-block">
                    <form method="POST" action="/tasks/{{$task->id}}/bids">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="price" class="col-md-4 control-label">Price</label>
                            <input type="text" id="price" name="price" class="form-control">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Bid</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
