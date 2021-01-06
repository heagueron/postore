@extends('layouts.admin')

@section('title', 'Admin|Companies')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
         
        {{-- MODALS --}}
            @include('admin.companies.create')

            <div class="d-flex justify-content-between mb-2">

                <h3>COMPANIES</h3>

                {{-- Open Create Company Modal --}}
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createCompanyModal">
                    <i class="fas fa-plus-circle"></i>
                </button>

            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Company</th>
                        <th>User</th>
                        <th>RJs</th>
                        <th>A RJs</th>
                        <th>E</th>
                        <th>D</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($companies as $company)
                        <tr></tr>
                        <tr>
                            <td>{{ $company->name }}</td>
                        </tr>
                    @empty
                        {{__('NO COMPANIES FOUND')}}
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection