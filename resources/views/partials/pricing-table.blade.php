<section class="pricing py-5 m-5">
  <div class="container">
    <div class="row">
      <!-- Free Tier -->
      <div class="col-lg-4">
        <div class="card mb-5 mb-lg-0" >
          <div class="card-body card-price-element">
            <h5 class="card-title text-muted text-uppercase text-center">{{ \App\Plan::find(1)->name }}</h5>
            <h6 class="card-price text-center">${{ \App\Plan::find(1)->value }}<span class="period">/{{ __('text.crPost')}}</span></h6>
            <hr>
            <ul class="fa-ul">
              <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ __('text.crDuration', ['duration' => \App\Option::find(1)->value]) }}</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ __('text.crShareTwitter') }}</li>
              <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>{{ __('text.crShowLogo') }}</li>
              <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>{{ __('text.crYellowBG') }}</li>
              <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>{{ __('text.crMFP') }}</li>
              <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>{{ __('text.crMCP') }}</li>
            </ul>

              <input type="radio" style="display:none" id="plan-free" name="plan_id" value="1">

            <label for="plan-free">{{__('SELECT')}}</label>
          </div>
        </div>
      </div>
      <!-- PRO Tier -->
      <div class="col-lg-4">
        <div class="card mb-5 mb-lg-0">
          <div class="card-body card-price-element" style="border: 4px solid yellow;">
            <h5 class="card-title text-muted text-uppercase text-center">{{ \App\Plan::find(2)->name }}</h5>
            <h6 class="card-price text-center">${{ \App\Plan::find(2)->value }}<span class="period">/{{ __('text.crPost')}}</span></h6>
            <hr>
            <ul class="fa-ul">
              <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ __('text.crDuration', ['duration' => \App\Option::find(1)->value]) }}</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ __('text.crShareTwitter') }}</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ __('text.crShowLogo') }}</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ __('text.crYellowBG') }}</li>
              <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>{{ __('text.crMFP') }}</li>
              <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>{{ __('text.crMCP') }}</li>
            </ul>

              <input type="radio" style="display:none" id="plan-pro" name="plan_id" value="2" checked>

            <label for="plan-pro">{{__('SELECT')}}</label>
          </div>
        </div>
      </div>
      <!-- PREMIUM Tier -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-body card-price-element">
            <h5 class="card-title text-muted text-uppercase text-center">{{ \App\Plan::find(3)->name }}</h5>
            <h6 class="card-price text-center">${{ \App\Plan::find(3)->value }}<span class="period">/{{ __('text.crPost')}}</span></h6>
            <hr>
            <ul class="fa-ul">
              <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ __('text.crDuration', ['duration' => \App\Option::find(1)->value]) }}</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ __('text.crShareTwitter') }}</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ __('text.crShowLogo') }}</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ __('text.crYellowBG') }}</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ __('text.crMFP') }}</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ __('text.crMCP') }}</li>
            </ul>

              <input type="radio" style="display:none" id="plan-premium" name="plan_id" value="3">

            <label for="plan-premium">{{__('SELECT')}}</label>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>