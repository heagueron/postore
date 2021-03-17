@extends('layouts.admin')

@section('title', 'Admin|Options')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            {{-- MODALS --}}
            @include('admin.options.createTextOption')
            @include('admin.options.createOption')
         
            <div class="d-flex justify-content-between my-2 p-2"  style="background-color:#ffffff;">

                <h3>TEXT OPTIONS</h3>
                {{-- Open Create Text Option Modal --}}
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createTextOptionModal">
                    <i class="fas fa-plus-circle"></i>
                </button>

            </div>

            {{-- Text Options --}}
            <table class="table" style="background-color:#ffffff;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Value</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($textOptions as $textOption)

                        <tr>
                            <td>{{$textOption->id}}</td>
                            <td>{{$textOption->name}}</td>
                            <td>{{$textOption->value}}</td>

                            {{-- ACTIONS --}}
                        
                            {{-- Edit --}}
                            <td>
                                <form method="GET" action="{{ route('admin.textOptions.edit', $textOption->id) }}">
                                    <button type="submit" style="border:none; background-color:transparent;" title="Edit">
                                        <i class="fa fa-edit" style="font-size:0.75rem;"></i>
                                    </button>
                                </form>
                            </td>

                            {{-- Delete --}}
                            <td></td>
                            
                        </tr>

                    @empty
                        {{__('NO TEXTOPTION FOUND')}}
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-between my-2 p-2"  style="background-color:#ffffff;">

                <h3>NUMERIC OPTIONS</h3>
                {{-- Open Create Numeric Option Modal --}}
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createOptionModal">
                    <i class="fas fa-plus-circle"></i>
                </button>

            </div>

            {{-- Numeric Options --}}
            <table class="table" style="background-color:#ffffff;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Value</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($options as $option)

                        <tr>
                            <td>{{$option->id}}</td>
                            <td>{{$option->name}}</td>
                            <td>{{$option->value}}</td>

                            {{-- ACTIONS --}}
                        
                            {{-- Edit --}}
                            <td>
                                <form method="GET" action="{{ route('admin.options.edit', $option->id) }}">
                                    <button type="submit" style="border:none; background-color:transparent;" title="Edit">
                                        <i class="fa fa-edit" style="font-size:0.75rem;"></i>
                                    </button>
                                </form>
                            </td>

                            {{-- Delete --}}
                            <td></td>
                            
                        </tr>

                    @empty
                        {{__('NO NUMERIC OPTION FOUND')}}
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>


@endsection