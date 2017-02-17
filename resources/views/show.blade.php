@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Simple Ajax Laravel 5.3</h3>
            <div class="panel panel-default">
                <div class="panel-body">
                    @if(Session::has('alert-success'))
                        <div class="alert alert-success">
                            {{ Session::get('alert-success') }}
                        </div>
                    @endif
                    <table class="table table-striped" id="table">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>                            
                        </tr>
                        <tr>
                            <td>{{$article->id}}</td>
                            <td>{{$article->title}}</td>
                            <td>{{$article->description}}</td>
                        </tr>
                    </table>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('article.index') }}"> Back</a>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

   