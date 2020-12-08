@extends('layouts.admin')

@section('title', 'Remote Jobs')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="d-flex mb-4">
                <a  rel="nofollow"
                    href="{{ route('admin.api_jobs.rok') }}" 
                    alt="Get api jobs" class="post-button mr-2">
                    {{ __('Get Jobs from R|OK') }}
                </a>
                <a  rel="nofollow"
                    href="{{ route('admin.api_jobs.remotive') }}" 
                    alt="Get api jobs" class="post-button mr-2">
                    {{ __('Get Jobs from remotive') }}
                </a>
                <a  rel="nofollow"
                    href="{{ route('admin.api_jobs.working-nomads') }}" 
                    alt="Get api jobs" class="post-button mr-2">
                    {{ __('Get Jobs from working nomads') }}
                </a>
                <a  rel="nofollow"
                    href="{{ route('admin.api_jobs.github') }}" 
                    alt="Get api jobs" class="post-button mr-2">
                    {{ __('Get Jobs from github') }}
                </a>
            </div>
                
            <table class="table">
                <thead>
                <tr>
                    <th>{{__('Remote Jobs')}}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody>
                
                @forelse($remjobs as $remjob)
                    <tr>
                        <td>{{ $remjob->company->name }}</td>
                        <td>
                            {{ $remjob->position }}<br/>
                            <small>{{$remjob->slug}}</small>
                        </td>
                        <td>{{ $remjob->created_at->diffForHumans() }}</td>

                        {{-- SOURCE --}}
                        @if( $remjob->external_api == 'https://remoteok.io' )
                            <td> {{__('ROK')}}</td>
                        @elseif( $remjob->external_api == 'https://remotive.io/' )
                            <td> {{__('RMV')}}</td>
                        @elseif( $remjob->external_api == 'https://www.workingnomads.co/' )
                            <td> {{__('WNM')}}</td>
                        @elseif( $remjob->external_api == 'https://jobs.github.com/positions' )
                        <td> {{__('GH')}}</td>
                        @else
                            <td style="color:orange"> {{__('RP')}}</td>
                        @endif

                        {{-- TWITTER SHARE COUNT --}}
                        <td>{{ $remjob->twitterPosts()->count() }}</td>

                        <td class="d-flex justify-content-left">
                            
                            {{-- Tweet --}}
                            <div>
                                <a class="ml-2" href="{{ route('admin.remjobs.tweet', $remjob->id) }}">
                                    <i class="fab fa-twitter" style="font-size:18px;color:#0066ff"></i>
                                </a>
                            </div>

                            {{-- Delete --}}
                            <div>
                                <form method="POST" action="{{ route('admin.remjobs.destroy', $remjob->id) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="border:none; background-color:transparent;">
                                        <i class="fa fa-trash" style="font-size:18px;color:red"></i>
                                    </button>
                                </form>
                            </div>

                            @if( $remjob->total )
                            {{-- Edit --}}
                            <div>
                                <a class="ml-2" href="{{ route('admin.remjobs.edit', $remjob->id) }}">
                                    <i class="fa fa-edit" style="font-size:18px;"></i>
                                </a>
                            </div>
                            @endif

                            {{-- Inactivate --}}
                            <div>
                            
                                <form action="{{ route('admin.remjobs.inactivate', $remjob->id) }}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" style="border:none;background-color:transparente">
                                        <i class="fa fa-ban"  aria-hidden="true" style="font-size:18px;"></i>
                                    </button>
                                </form>
                                    
                                </a>
                            </div>
                        </td>
                    </tr> 
                @empty
                    {{__('NO REMOTE JOBS FOUND')}}
                @endforelse

                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection