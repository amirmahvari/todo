@extends('layouts.app')
@section('content')
    <div class="container">
        <form action="{{route('task.store')}}" method="post">
            @csrf
            <fieldset>
                <legend>{{$pageTitle}}</legend>
                <div class="mb-3">
                    <label for="title" class="form-label">{{__('Title')}}</label>
                    <input
                            type="text"
                            value="{{old('title')}}"
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
                            placeholder="explain about">{{old('description')}}</textarea>
                    @error('description') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="labels" class="form-label">{{__('Labels')}}</label>
                    <select multiple
                            id="labels"
                            name="labels[]"
                            class="form-control">
                        @foreach($labels as $label)
                            <option value="{{$label->id}}">{{$label->label}}</option>
                        @endforeach
                    </select>
                    @error('labels') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
            </fieldset>
        </form>
    </div>
@endsection
