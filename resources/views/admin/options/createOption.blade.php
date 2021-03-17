<!-- The Modal -->
<div class="modal" id="createOptionModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Create a Numeric Option</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="{{ route('admin.options.store') }}" method="post">
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

            <!-- value -->
            <div>
                <span class="rp-group__head">Value*</span>

                <input  type="text" name="value"
                        value="{{ !is_null( old('value'))? old('value') : '' }}"               
                >
                
                @error('value') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            <!-- description -->
            <div>
                <span class="rp-group__head">Description*</span>

                <textarea name="description" class="form-control post-text-container" autocomplete="off" 
                        rows="4" cols="50">
                        {{ !is_null( old('description'))? old('description') : '' }}
                </textarea>
                
                @error('description') 
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