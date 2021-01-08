@extends('layouts.admin')

@section('title', 'Admin|Companies')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
         
        {{-- MODALS --}}
            @include('admin.companies.create')

            <div class="d-flex justify-content-between mb-2 p-2"  style="background-color:#ffffff;">

                <h3>COMPANIES</h3>

                {{-- Open Create Company Modal --}}
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createCompanyModal">
                    <i class="fas fa-plus-circle"></i>
                </button>

            </div>

            <table class="table" style="background-color:#ffffff;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Logo</th>
                        <th>Company</th>
                        <th>User</th>
                        <th>RJs</th>
                        <th>A RJs</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($companies as $company)

                        <tr>
                            <td>{{$company->id}}</td>
                            <td>
                                @if( $company->user != null )

                                    {{-- remjob.io client company --}}
                                    @if( $company->logo != null )
                                        <img src="{{ asset('storage/' . $company->logo ) }}" alt="Logo" width="60" height=auto>
                                    @else
                                        <img src="{{ asset('storage/logos/nologo.png') }}" alt="NL" class="jobrow-company-logo">
                                    @endif
                                @else

                                    {{-- external apis posts --}}
                                    @if( $company->logo != null )
                                        <img src="{{ $company->logo }}" alt="Logo" width="60" height=auto>
                                    @else
                                        <img src="{{ asset('storage/logos/nologo.png') }}" alt="NL" class="jobrow-company-logo">
                                     @endif

                                @endif

                            </td>

                            <td>{{ $company->name }}</td>

                            @if( $company->user != null )
                                <td>
                                    {{ $company->user->name }}<br/>
                                    <small>( {{ $company->user->id }} )</small>
                                </td>
                            @else 
                                <td>
                                    From APIs
                                </td>
                            @endif

                            <td>{{ $company->remjobs()->count() }}</td>

                            <td>{{ $company->remjobs()->where('active', 1)->count() }}</td>


                            {{-- ACTIONS --}}
                        
                            {{-- Edit --}}
                            <td>
                            
                                <form method="GET" action="{{ route('admin.companies.edit', $company->id) }}">
                                    <button type="submit" style="border:none; background-color:transparent;" title="Edit">
                                        <i class="fa fa-edit" style="font-size:0.75rem;"></i>
                                    </button>
                                </form>

                            </td>

                            {{-- Delete --}}
                            <td>
                                <form method="POST" action="{{ route('admin.companies.destroy', $company->id) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="border:none; background-color:transparent;" title="Destroy">
                                        <i class="fa fa-trash" style="font-size:0.75rem;color:red"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>

                    @empty
                        {{__('NO COMPANIES FOUND')}}
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>


@endsection