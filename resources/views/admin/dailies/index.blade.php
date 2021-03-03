@extends('layouts.admin')

@section('title', 'Admin|Dailies')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="d-flex justify-content-between mb-2 p-2"  style="background-color:#ffffff;">

                <h3>DAILIES</h3>

                {{-- UPDATE ACTION --}}
                <a href="{{ route('admin.dailies.updateAll') }}" type="button" class="btn btn-success">
                    Update dailies
                </a>

            </div>

            <table class="table" style="background-color:#ffffff;">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th colspan="4">Hits</th>
                        <th>+Users</th>
                        <th colspan="3">Sales</th>
                    </tr>
                    <tr><td></td><td>Landing</td><td>Cat</td><td>Details</td><td>FAQ</td><td>UNQ</td><td></td><td>P1</td><td>P2</td><td>P3</td></tr>
                </thead>
                <tbody>
                    @forelse($dailies as $daily)

                        <tr>

                            {{--Date--}}
                            <td>{{ $daily->track_day }}</td>
                            
                            {{--Hits--}}
                            <td>{{ $daily->hits_landing }}</td>
                            <td>{{ $daily->hits_category }}</td>
                            <td>{{ $daily->hits_details }}</td>
                            <td>{{ $daily->hits_faq }}</td>
                            <td>{{ $daily->distinct_visitors }}</td>

                            {{-- Registered users--}}
                            <td>{{ $daily->registered_users }}</td>

                            {{--Sales--}}
                            <td>{{ $daily->sales_p1 }}</td>
                            <td>{{ $daily->sales_p2 }}</td>
                            <td>{{ $daily->sales_p3 }}</td>

                        </tr>

                    @empty
                        <div class="m-2">{{__('NO DAILY FOUND')}}</div>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex">
                {{-- CLEAN DETAILED REGISTERS ACTION --}}
                <a href="{{ route('admin.visits.cleanAll') }}" type="button" class="btn btn-danger ml-auto">
                    Clean visit registers
                </a>
            </div>

        </div>
    </div>


@endsection