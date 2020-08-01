@extends('layouts.master')

@section('title')
    Blockchains
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Blockchains</li>
        </ol>
    </nav>
@endsection

@section('content')

    <div class="col-12 card-helppo p-3">
        <h3>Blockchains</h3>
        
        <table class="table table-striped">
            <thead>
                </tr>
                    <th scope="col">#</th>
                    <th scope="col">Version</th>
                    <th scope="col">Difficulty</th>
                    <th scope="col">Type</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($blockchains as $blockchain)
                    <tr>
                        <th scope="row">{{$blockchain->id}}</th>
                        <td>{{$blockchain->version}}</td>
                        <td>{{$blockchain->difficulty}}</td>
                        <td>{{$blockchain->type}}</td>
                        <td><a href="{{route('blockchains.show',$blockchain->id)}}">Blocks</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection 