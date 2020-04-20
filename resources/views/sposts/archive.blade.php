@extends('layouts.app')

@section('title', 'Archives')

@section('content')

{{-- Published Posts --}}
<div class="mt-4">
  <h3> Published Posts</h3>

  <div class="mt-4">
    <ul class="list-group list-group-flush">
        @forelse ($sposts as $spost)
            <li class="list-group-item">
              <x-spost-item mode="archive" :spost="$spost"/> 
            </li>
        @empty
            <h3>No post scheduled</h3>
        @endforelse
    </ul>
  </div>

  {{-- Pagination Links --}}
  {{ $sposts->links() }}

</div>


@endsection