@extends('layouts.app')
@section('content')
    <div class="container">
        <form action="{{route('label.update',$label)}}" method="post">
            @csrf
            @method('PATCH')
            <fieldset>
                <legend>{{$pageTitle}}</legend>
                <div class="mb-3">
                    <label for="label" class="form-label">{{__('Label')}}</label>
                    <input
                            type="text"
                            value="{{$label->label}}"
                            name="label"
                            id="label"
                            class="form-control"
                            placeholder="do somethings">
                    @error('label') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
            </fieldset>
        </form>
    </div>
@endsection
