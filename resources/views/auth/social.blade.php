@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <br/>
                    <br/>
                    <h2 class="panel-heading">Login</h2>
                    <br/>
                    <hr/>
                    <br/>
                    @if($errors->any())
                        <h4>{{$errors->first()}}</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
