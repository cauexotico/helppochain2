@extends('layouts.master')

@section('title')
    {{$project->name}}
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('projects.index')}}">Projects</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$project->name}}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="col-12 card-helppo p-3">
        <h3 class="card-title">{{$project->name}} <small>&#8226 {{$project->type}}</small></h3>
        <div class="infos">
            <div class="form-group">
                <label for="api_key">API Key</label>
                <input type="text" class="form-control" id="api_key" placeholder="API Key" value="{{$project->api_key}}">
            </div>
            <div class="form-group">
                <label for="api_secret">API Secret</label>
                <input type="text" class="form-control" id="api_secret" placeholder="API Secret" value="{{$project->api_secret}}">
            </div>
            <p>Blockchain: <a href="{{route('blockchains.show',$project->blockchain->id)}}">{{$project->blockchain->id}}</a></p>
            <p>Difficulty: {{$project->blockchain->difficulty}}</p>
            <p>Version: {{$project->blockchain->version}}</p>
        </div>
    </div>

    <div class="col-12 card-helppo p-3 mt-3">
        <h3>Add Transaction</h3>
        <form method="POST" action="{{action('ProjectController@createTransaction', $project->id)}}">
            @csrf
            <input class="form-control" type="text" name="data" id="data" placeholder='{"name":"John"}'>
            <input class="form-control btn btn-success mt-2" type="submit" value="Add Transaction">
        </form>
    </div>

    <div class="col-12 card-helppo p-3 mt-3">
        <h3>Transactions</h3>
        <table class="table table-striped">
            <thead>
                </tr>
                    <th scope="col">Hash</th>
                    <th scope="col">Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach($project->transactions as $transaction)
                    <tr>
                        <td>{{$transaction->hash}}</td>
                        <td>{{$transaction->data}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection