@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h1>{{$pageTitle}}</h1>
            </div>
            <div class="col-lg-6 text-right">
                <a href="{{route('label.create')}}" class="btn btn-success">{{__('Create Label')}}</a>
            </div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{__('Label')}}</th>
                <th scope="col">{{__('Actions')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($labels as $key=>$label)
                <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td>{{$label->label}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('label.edit',$label)}}" class="btn btn-info">{{__('Edit')}}</a>
                            <form action="{{route('label.destroy',$label)}}" method="post">
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
        {{$labels->render()}}
    </div>
@endsection
