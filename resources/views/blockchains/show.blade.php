@extends('layouts.master')

@section('title')
    #{{$blockchain->id}} {{$blockchain->name}}
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
        <h3>Blockchain #{{$blockchain->id}} {{$blockchain->name}}</h3>
        <div class="infos">
            ID: {{$blockchain->id}} <br>
            Name: {{$blockchain->name}} <br>
            Version: {{$blockchain->version}} <br>
            Height: {{$blockchain->height}} <br>
            Difficulty: {{$blockchain->difficulty}} <br>
            Type: {{$blockchain->type}} <br>
            Validade: {{$blockchain->valid}}
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
                    <th scope="col">Merkle Root</th>
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
                        <td>{{$block->buildMerkleTreeRoot()}}</td>
                        <td>
                            @if($block->status == 'not_mined')
                                <a href="{{route('block.mine', $block->id)}}">Mine</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection