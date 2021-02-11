@extends('layouts.admin')

@section('title', 'Admin|Plans')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
         
            <div class="d-flex justify-content-between mb-2 p-2"  style="background-color:#ffffff;">

                <h3>PLANS</h3>

            </div>

            <table class="table" style="background-color:#ffffff;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Value</th>
                        <th>GR Permalink</th>
                        <th>GR Prod. ID</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)

                        <tr>
                            <td>{{$plan->id}}</td>
                            <td>{{$plan->name}}</td>
                            <td>{{$plan->description}}</td>
                            <td>{{$plan->value}}</td>
                            <td>{{$plan->gumroad_permalink}}</td>
                            <td>{{$plan->gumroad_product_id}}</td>

                            {{-- ACTIONS --}}
                        
                            {{-- Edit --}}
                            <td>
                                <form method="GET" action="{{ route('admin.plans.edit', $plan->id) }}">
                                    <button type="submit" style="border:none; background-color:transparent;" title="Edit">
                                        <i class="fa fa-edit" style="font-size:0.75rem;"></i>
                                    </button>
                                </form>
                            </td>

                            {{-- Delete --}}
                            <td></td>
                            

                        </tr>

                    @empty
                        {{__('NO PLANS FOUND')}}
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>


@endsection