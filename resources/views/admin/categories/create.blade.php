<!-- The Modal -->
<div class="modal" id="createCategoryModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Create a Category</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="{{ route('admin.categories.store') }}" method="post">
            @csrf

            <!-- name -->
            <div>
                <span class="rp-group__head">NAME*</span>
                <input  type="text" name="name"
                        value="{{ !is_null( old('name'))? old('name') : '' }}"               
                >
                @error('name') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            <!-- tag -->
            <div>
                <span class="rp-group__head">tag*</span>
                <input  type="text" name="tag"
                        value="{{ !is_null( old('tag'))? old('tag') : '' }}"               
                >
                @error('tag') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            <!-- user_id -->
            <div>
                <span class="rp-group__head">language*</span>
                <select name="language_id">
                    <option value="0">Select Language</option>
                    @foreach(\App\Language::all() as $language)
                        @if( old('language_id') == $language->id )
                            <option value="{{ $language->id }}" selected>{{ $language->name}}</option>
                        @else
                            <option value="{{ $language->id }}">{{ $language->name}}</option>
                        @endif
                    @endforeach
                </select>
                @error('language_id') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-warning">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>

      <!-- Modal footer -->
      <!-- <div class="modal-footer">
        
      </div> -->

    </div>
  </div>
</div>