@extends('layouts.admin')

@section('title', 'Remote Jobs')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th>{{__('Remote Jobs')}}</th>
                    <th></th>
                    <th></th>
                    <th>{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody>
                
                @forelse($remjobs as $remjob)
                    <tr>
                        <td>{{ $remjob->company_name }}</td>
                        <td>{{ $remjob->position }}</td>
                        <td>{{ $remjob->created_at }}</td>
                        <td class="d-flex justify-content-between">
                            <div>
                                <a class="ml-2" href="{{ route('admin.remjobs.edit', $remjob->id) }}">
                                    <i class="fa fa-edit" style="font-size:18px;"></i>
                                </a>
                            </div>
                            <div>
                                <form method="POST" action="{{ route('admin.remjobs.destroy', $remjob->id) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="border:none; background-color:transparent;">
                                        <i class="fa fa-trash" style="font-size:18px;color:red"></i>
                                    </button>
                                </form>
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