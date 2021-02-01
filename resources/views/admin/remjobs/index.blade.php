@extends('layouts.admin')

@section('title', 'Admin|Remote Jobs')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="d-flex mb-4 text-center p-2" style="background-color:#ffffff;">
                <a  rel="nofollow"
                    href="{{ route('admin.api_jobs.rok') }}" 
                    alt="Get api jobs" class="post-button mr-2">
                    Get Jobs from R|OK
                </a>
                <a  rel="nofollow"
                    href="{{ route('admin.api_jobs.remotive') }}" 
                    alt="Get api jobs" class="post-button mr-2">
                    Get Jobs from remotive
                </a>
                <a  rel="nofollow"
                    href="{{ route('admin.api_jobs.working-nomads') }}" 
                    alt="Get api jobs" class="post-button mr-2">
                    Get Jobs from working nomads
                </a>
                <a  rel="nofollow"
                    href="{{ route('admin.api_jobs.github') }}" 
                    alt="Get api jobs" class="post-button mr-2">
                    Get Jobs from github
                </a>
            </div>
                
            <table class="table" style="background-color:#ffffff;">
                <thead>
                <tr>
                    <th>Company</th>
                    <th>Position</th>
                    <th>Act</th>
                    <th>Date</th>
                    <th>Src</th>
                    <th>Tw#</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                
                @forelse($remjobs as $remjob)
                    <tr>
                        @if( $remjob->company )
                            <td>{{ $remjob->company->name }}</td>
                        @else 
                            <td >{{ __('*** NO COMPANY! *** ') }}</td>
                        @endif
                        <td>
                            {{ $remjob->position }}<br/>
                            <small>{{$remjob->slug}}</small>
                        </td>
                        <td>
                            @if( $remjob->active )
                                <i class="fa fa-check" style="font-size:18px;color:#0066ff"></i>
                            @endif
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
                            
                            @if( $remjob->active )
                                {{-- Tweet --}}
                                <div>
                                    <a class="ml-2" href="{{ route('admin.remjobs.tweet', $remjob->id) }}" title="Share on Twitter">
                                        <i class="fab fa-twitter" style="font-size:18px;color:#0066ff"></i>
                                    </a>
                                </div>
                            @endif

                            {{-- Delete --}}
                            <div>
                                <form method="POST" action="{{ route('admin.remjobs.destroy', $remjob->id) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="border:none; background-color:transparent;" title="Destroy">
                                        <i class="fa fa-trash" style="font-size:18px;color:red"></i>
                                    </button>
                                </form>
                            </div>

                            
                            {{-- Edit --}}
                            <div>
                                <a class="ml-2" href="{{ route('admin.remjobs.edit', $remjob->id) }}" title="Edit">
                                    <i class="fa fa-edit" style="font-size:18px;"></i>
                                </a>
                            </div>
                            

                            {{-- Inactivate/Activate --}}
                            <div>
                            
                                <form action="{{ route('admin.remjobs.toggleActive', $remjob->id) }}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" style="border:none;background-color:transparente">
                                        @if( $remjob->active )
                                            <i class="fa fa-ban"  aria-hidden="true" style="font-size:18px;" title="Inactivate"></i>
                                        @else
                                            <i class="fas fa-arrow-up" aria-hidden="true" style="font-size:18px;" title="Activate"></i>
                                        @endif
                                    </button>
                                </form>
                               
                            </div>
                        </td>
                    </tr> 
                @empty
                    NO REMOTE JOBS FOUND
                @endforelse

                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection