@extends('layouts.admin')

@section('title', 'Admin|Tags')

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>TAGS</h1>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Remjobs</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($tags as $tag)
                    <tr>
                        <td>{{ $tag->id }}</td>
                        <td>{{ $tag->name }}</td>
                        <td>{{ $tag->remjobs->count() }}</td>
                        {{--Actions--}}
                        <td>
                        @if($tag->remjobs->count()==0)
                            <form method="POST" action="{{ route('admin.tags.destroy', $tag->id) }}">
                                @csrf @method('DELETE')
                                <button type="submit" style="border:none; background-color:transparent;" title="Destroy">
                                    <i class="fa fa-trash" style="font-size:18px;color:red"></i>
                                </button>
                            </form>
                        @endif
                        </td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection