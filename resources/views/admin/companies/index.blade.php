@extends('layouts.admin')

@section('title', 'Remote Jobs')

@section('content')
<!-- <div class="container"> -->
    <div class="row justify-content-center">
        <div class="col-md-12">

            {{-- MODALS --}}
            @include('admin.companies.create')

            <div class="d-flex justify-content-between mb-2">
                <h2>COMPANIES </h2>
                <!-- Open Create Company Modal -->
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createCompanyModal">
                    <i class="fas fa-plus-circle"></i>
                </button>
            </div>

                
            <table class="table">
                <thead>
                <tr>
                    <th>{{__('Logo')}}</th>
                    <th>{{__('Company')}}</th>
                    <th>User</th>
                    <th>RJs</th>
                    <th>A-RJs</th>
                    <th>E</th>
                    <th>D</th>
                </tr>
                </thead>
                <tbody>
                
                @forelse($companies as $company)
                    <tr>
                        <td class="d-flex justify-content-left">
                            @if( $company->logo != null )
                                <img src="{{ asset('storage/' . $company->logo ) }}" alt="{{ Str::of( $company->name )->substr(0, 1) }}" width="60" height=auto>
                            @else
                                <img src="{{ asset('storage/logos/nologo.png') }}" alt="NL" class="jobrow-company-logo">
                            @endif
                        </td>
                        <td>
                            {{ $company->name }}
                        </td>
                        <td>
                            {{ $company->user->name }}<br/>
                            <small>( {{ $company->user->id }} )</small>
                        </td>
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

<!-- </div> -->


@endsection