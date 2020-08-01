@extends('layouts.master')

@section('title')
    Create Project
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('projects.index')}}">Projects</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Project</li>
        </ol>
    </nav>
@endsection

@section('content')

    <div class="col-12 card-helppo p-3">
        <h3>Create Project</h3>

        <div class="row">
            <div class="col-6">
                <form method="POST" action="{{ action('ProjectController@store') }}">
                    @csrf
            
                    <input class="form-control" type="text" name="name" id="name" placeholder="Project Name">
                    <label for="type-solo">Solo</label>
                    <input type="radio" name="type" id="type-solo" value="solo">
                    <label for="type-shared">Shared</label>
                    <input type="radio" name="type" id="type-shared" value="shared">
                    <input class="form-control" type="number" name="difficulty" id="difficulty" placeholder="Difficulty" min="1" max="18">
                    <input class="form-control btn btn-primary mt-2" type="submit" value="Create">
                </form>
            </div>
        </div>
    </div>
    
@endsection