@extends('layouts.master')

@section('title')
    Blockchain {{$blockchain->id}}
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('blockchains.index')}}">Blockchains</a></li>
            <li class="breadcrumb-item active" aria-current="page">Blockchain #{{$blockchain->id}}</li>
        </ol>
    </nav>
@endsection

@section('content')

    <div class="col-12 card-helppo p-3">
        <h3>Blockchain {{$blockchain->id}}</h3>
        <div class="infos">
            ID: {{$blockchain->id}} <br>
            Version: {{$blockchain->version}} <br>
            Difficulty: {{$blockchain->difficulty}} <br>
            Type: {{$blockchain->type}} <br>
        </div>

        <hr>

        <h3>Blocks</h3>
        <table class="table table-striped">
            <thead>
                </tr>
                    <th scope="col">#</th>
                    <th scope="col">Nonce</th>
                    <th scope="col">Status</th>
                    <th scope="col">Previous Hash</th>
                    <th scope="col">Hash</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($blockchain->blocks as $block)
                    <tr>
                        <th scope="row">{{$block->id}}</th>
                        <td>{{$block->nonce}}</td>
                        <td>{{$block->status}}</td>
                        <td>{{$block->getShortnedPreviousHash()}}</td>
                        <td>{{$block->getShortnedHash()}}</td>
                        <td><a href="#">Mine</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection