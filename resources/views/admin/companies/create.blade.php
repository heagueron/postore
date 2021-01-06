<!-- The Modal -->
<div class="modal" id="createCompanyModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Create a Company</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="{{ route('admin.companies.store') }}" method="post" enctype="multipart/form-data" id="post-job-form">
            @csrf

            <!-- user id -->
            <div>
                <span class="rp-group__head">USER ID*</span>
                <input  type="text" name="user_id" title="user id of company owner"
                        value="{{ !is_null( old('user_id'))? old('user_id') : '' }}"               
                >
                @error('user_id') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            @include('partials.first-company')
            <input type="hidden" id="storedLogo" value="logos/nologo.png">
            @include('partials.more-details-first-company')

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