@extends('layouts.admin')

@section('title', 'Admin|Users')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
         
        {{-- MODALS --}}
            @include('admin.users.create')

            <div class="d-flex justify-content-between mb-2 p-2" style="background-color:#ffffff;">

                <h3>USERS</h3>

                {{-- Open Create Company Modal --}}
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createUserModal">
                    <i class="fas fa-plus-circle"></i>
                </button>

            </div>

            <table class="table" style="background-color:#ffffff;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)

                        <tr>
                            <td> {{ $user->id }} </td>

                            <td> {{ $user->name }} </td>

                            <td> {{ $user->email }} </td>

                            @if( $user->companies()->count() > 0 )
                                <td> {{$user->companies()->first()->name }} </td>
                            @else 
                                <td> {{ None }}</td>
                            @endif

                            {{-- ACTIONS --}}
                        
                            {{-- Edit --}}
                            <td>

                                    <button type="submit" style="border:none; background-color:transparent;" title="Edit">
                                        <i class="fa fa-edit" style="font-size:0.75rem;"></i>
                                    </button>
   

                            </td>

                            {{-- Delete --}}
                            <td>

                                    <button type="submit" style="border:none; background-color:transparent;" title="Destroy">
                                        <i class="fa fa-trash" style="font-size:0.75rem;color:red"></i>
                                    </button>

                            </td>

                        </tr>

                    @empty
                        {{__('NO USERS FOUND')}}
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>


@endsection