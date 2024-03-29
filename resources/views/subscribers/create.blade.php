@php
   $localeId = \App\Language::where('short_name', \App::getLocale())->first()->id;
@endphp

<!-- The Modal -->
<div class="modal" id="createSubscriberModal">
  <div class="modal-dialog">
    <div class="modal-content modal-content-subscribe">

      <!-- Modal Header -->
      <!-- <div class="modal-header">
        <h4 class="modal-title">Create a Company</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> -->

      <!-- Modal body -->
      <div class="modal-body" style="background-color:ligthblue !important;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="text-center mt-1 mb-3">Get daily remote jobs</h2>
        <form action="{{ route('subscribers.store') }}" method="post">
            @csrf

            <!-- name -->
            <div>
                <input  type="text" name="name" placeholder="your first name ... "
                        value="{{ !is_null( old('name'))? old('name') : '' }}"               
                >
                @error('name') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>
            
            <!-- email -->
            <div>
                <input  type="text" name="email" placeholder="your email ... "
                        value="{{ !is_null( old('email'))? old('email') : '' }}"               
                >
                @error('email') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>
            
            <!-- category -->
            <div>
                <select name="category_id">

                    <option value=""><p style="color:#d9d9d9 !important;">select a category ...</p> </option>
                   
                    @foreach( \App\Category::where('language_id', $localeId)->oldest()->get() as $category )
                        {{-- Exclude categories without tag --}}
                        @if( $category->tag != '' and $category->tag != 'all' and $category->tag != 'todos')
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endif
                    @endforeach

                  
                </select>
                @error('category_id') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            <!-- frecuency -->
            <!-- <div>
                <select name="frecuency">

                    <option value=""><p style="color:#d9d9d9 !important;">select a frequency ...</p> </option>
                   
                    <option value="daily">{{ __('Daily') }}</option>
                    <option value="weekly">{{ __('weekly') }}</option>
                    <option value="monthly">{{ __('monthly') }}</option>

                  
                </select>
                @error('frecuency') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div> -->

            <div class="text-center mt-5" style="margin-left:12px; margin-right:12px;">
                <button type="submit" class="btn btn-warning btn-block mb-3">{{__('Subscribe me')}}</button>
                <small class="mt-4">{{__('We do not send spam. You will be able to unsubscribe at any time.')}}</small>
            </div>
            

            

        </form>
      </div>

      <!-- Modal footer -->
      <!-- <div class="modal-footer">
        
      </div> -->

    </div>
  </div>
</div>