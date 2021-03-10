@extends('layouts.admin')

@section('title', 'Admin|Remote Jobs')

@section('content')

<div class="container">

    {{-- MODALS --}}
    @include('admin.companies.modal')

    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="d-flex mb-4 text-center p-2" style="background-color:#ffffff;">
                <a rel="nofollow" href="{{ route('admin.api_jobs.rok') }}" class="post-button mr-2">
                    R|OK
                </a>
                <a rel="nofollow" href="{{ route('admin.api_jobs.remotive') }}" class="post-button mr-2">
                    Remotive
                </a>
                <a rel="nofollow" href="{{ route('admin.api_jobs.working-nomads') }}" class="post-button mr-2">
                    WNMs
                </a>
                <a rel="nofollow" href="{{ route('admin.api_jobs.github') }}" class="post-button mr-2">
                    Github
                </a>
                <a rel="nofollow" href="{{ route('admin.api_jobs.stack') }}" class="post-button mr-2">
                    StackOverflow
                </a>
                <a rel="nofollow" href="{{ route('admin.api_jobs.themuse') }}" class="post-button mr-2">
                    TheMuse
                </a>
                <a href="{{ route('admin.remjobs.create') }}" type="button" class="btn btn-success ml-auto">
                    <i class="fas fa-plus-circle"></i>
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
                            <td>
                                <a data-toggle="modal" data-target="#companyModal" title="{{ $remjob->company->name . ' jobs' }}" class="open-AddBookDialog"
                                    data-id="{{ $remjob->company->id }}" data-name="{{ $remjob->company->name }}" >
                                    {{ $remjob->company->name }}
                                </a>
                            </td>
                            
                        @else 
                            <td >{{ __('*** NO COMPANY! *** ') }}</td>
                        @endif
                        <td>
                            <a href="{{ route( 'remjobs.show', $remjob->slug ) }}" target="_blank" style="text-decoration:none;">
                                {{ $remjob->position }}<br/>
                                <small>{{$remjob->slug}}</small>
                            </a>
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
                        @elseif( $remjob->external_api == 'http://stackoverflow.com/jobs/feed' )
                        <td> {{__('STACK')}}</td>
                        @elseif( $remjob->external_api == 'https://www.themuse.com/api/public/jobs' )
                        <td> {{__('MUSE')}}</td>
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

            <div>
                {{ $remjobs->links() }}   
            </div>

        </div>
    </div>
</div>
@endsection