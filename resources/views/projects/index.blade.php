@extends('layouts.master')

@section('title')
    Projects
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Projects</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="col-12 card-helppo p-3">
        <h3>Projects <a href="{{route('projects.create')}}">+</a></h3>

        <table class="table table-striped">
            <thead>
                </tr>
                    <th scope="col">#</th>
                    <th scope="col">Blockchain</th>
                    <th scope="col">Name</th>
                    <th scope="col">Difficulty</th>
                    <th scope="col">Type</th>
                    <th scope="col">Api Key</th>
                    <th scope="col">Api Secret</th>
                    <th scope="col">Start Version</th>
                    <th scope="col">Current Version</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr>
                        <th scope="row">{{$project->id}}</th>
                        <td><a href="{{route('blockchains.show',$project->blockchain_id)}}">{{$project->blockchain_id}}</a></td>
                        <td>{{$project->name}}</td>
                        <td>{{$project->blockchain->difficulty}}</td>
                        <td>{{$project->type}}</td>
                        <td>{{$project->api_key}}</td>
                        <td>{{$project->api_secret}}</td>
                        <td>{{$project->start_version}}</td>
                        <td>{{$project->current_version}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
@endsection