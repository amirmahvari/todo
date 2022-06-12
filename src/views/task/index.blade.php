@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h1>{{$pageTitle}}</h1>
            </div>
            <div class="col-lg-6 text-right">
                <a href="{{route('task.create')}}" class="btn btn-success">{{__('Task Create')}}</a>
            </div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{__('Title')}}</th>
                <th scope="col" width="60%">{{__('Description')}}</th>
                <th scope="col">{{__('Status')}}</th>
                <th scope="col">{{__('Actions')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $key=>$task)
                <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td>{{$task->title}}</td>
                    <td>{{$task->description}}</td>
                    <td>
                        <button class="btn btn-{{$task->status=='open' ? 'warning' : 'success'}}">
                            {{__(ucfirst($task->status))}}
                        </button>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('task.edit',$task)}}" class="btn btn-info">{{__('Edit')}}</a>
                            <form action="{{route('task.destroy',$task)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button
                                        type="submit"
                                        onclick="return confirm('Are you sure?')"
                                        class="btn btn-danger">{{__('Delete')}}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$tasks->render()}}
    </div>
@endsection
