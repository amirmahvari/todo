@extends('layouts.app')
@section('content')
    <div class="container">
        <form action="{{route('task.update',$task['id'])}}" method="post">
            @csrf
            @method('PATCH')
            <fieldset>
                <legend>{{$pageTitle}}</legend>
                <div class="mb-3">
                    <label for="title" class="form-label">{{__('Title')}}</label>
                    <input
                            type="text"
                            value="{{$task['title']}}"
                            name="title"
                            id="title"
                            class="form-control"
                            placeholder="do somethings">
                    @error('title') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">{{__('Description')}}</label>
                    <textarea
                            id="description"
                            name="description"
                            class="form-control"
                            placeholder="explain about">{{$task['description']}}</textarea>
                    @error('description') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">{{__('Status')}}</label>
                    <select id="status" name="status" class="form-control">
                        <option {{$task['status']=='open' ? 'selected' : ''}} value="open">{{__('Open')}}</option>
                        <option {{$task['status']=='close' ? 'selected' : ''}} value="close">{{__('Close')}}</option>
                    </select>
                    @error('status') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="labels" class="form-label">{{__('Labels')}}</label>
                    <select multiple
                            id="labels"
                            name="labels[]"
                            class="form-control">
                        @foreach($labels as $label)
                            <option {{in_array($label->id,$task['labels']) ? 'selected' : ''}} value="{{$label->id}}">{{$label->label}}</option>
                        @endforeach
                    </select>
                    @error('description') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
            </fieldset>
        </form>
    </div>
@endsection
