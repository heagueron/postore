@extends('layouts.admin')

@section('title', 'Admin|Categories')

@section('content')

<div class="container">
         
    {{-- MODALS --}}
    @include('admin.categories.create')

    <div class="card">

        <div class="card-header">
            <div class="d-flex justify-content-between mb-2 p-2">

                <h3>CATEGORIES</h3>

                {{-- Open Create Category Modal --}}
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createCategoryModal">
                    <i class="fas fa-plus-circle"></i>
                </button>

            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm table-hover" style="background-color:#ffffff;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Tag</th>
                        <th class="text-center">Lang</th>
                        <th class="text-center">Cr. at</th>
                        <th  class="text-center" colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)

                        <tr>
                            <td>{{$category->id}}</td>
                            <td>{{$category->name}}</td>
                            <td>{{$category->tag}}</td>
                            <td class="text-center">{{$category->language->short_name}}</td>
                            <td class="text-center">{{$category->created_at->toDateString()}}</td>

                            {{-- ACTIONS --}}
                        
                            {{-- Edit --}}
                            <td class="text-center">
                                <form method="GET" action="{{ route('admin.categories.edit', $category->id) }}">
                                    <button type="submit" style="border:none; background-color:transparent;" title="Edit">
                                        <i class="fa fa-edit" style="font-size:0.75rem;"></i>
                                    </button>
                                </form>
                            </td>

                            {{-- Delete --}}
                            <td></td>
                        </tr>

                    @empty
                        {{__('NO CATEGORIES FOUND')}}
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection