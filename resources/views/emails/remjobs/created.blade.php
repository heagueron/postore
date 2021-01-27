
    
    <div class="container" style="margin-top:7rem;">

        <div class="d-flex justify-content-between mt-5">

            <p>{{__('mails.crClientSalute')}}</p>

        </div>


        <div class="row mt-5">
            <div class="col-lg-9 col-sm-12 remjob-description">

                <p>{{ __(
                    'show.postDate',
                    [   'postDate' => \Carbon\Carbon::parse($remjob->created_at)->toFormattedDateString()] 
                    ) }}
                </p>

                <p>
                    <span style="font-weight:bold;">{{__('mails.companyLabel')}}</span>
                    <span>{{ $remjob->company->name }}</span>
                </p>

                <p>
                    <span style="font-weight:bold;">{{__('mails.positionLabel')}}</span>
                    <span>{{ $remjob->position }}</span>
                </p>

                <p>
                    <span style="font-weight:bold;">{{__('mails.categoryLabel')}}</span>
                    <span>{{ $remjob->category->name }}</span>
                </p>

                <p>
                    <span style="font-weight:bold;">{{__('mails.tagsLabel')}}</span>
                    <span>
                        @foreach( $remjob->tags()->take(5)->get() as $tag )
                            <button class="rp-tag-item"> {{ $tag->name }}</button>&nbsp;                
                        @endforeach
                    </span>
                    
                </p>

                {{-- DESCRIPTION --}}
                <div class="mt-5">
                    <p>{{__('mails.description: ')}}</p>
                    <div>{!! $remjob->description !!}</div>

                    @if($remjob->min_salary)
                        <p class="mt-2">
                            <span style="font-weight:bold;">{{__('mails.minSalaryLabel')}}</span>
                            <span>${{ number_format($remjob->min_salary,0,'.',',') }}</span>
                        </p>
                    @endif
                    @if($remjob->max_salary)
                        <p>
                            <span style="font-weight:bold;">{{__('mails.maxSalaryLabel')}}</span>
                            <span>${{ number_format($remjob->max_salary,0,'.',',')  }}</span>
                        </p>
                    @endif

                    @if($remjob->locations)
                        <p>
                            <span style="font-weight:bold;">{{__('mails.locationLabel: ')}}</span>
                            <span>{{ $remjob->locations }}</span>
                        </p>
                    @endif

                    <p>
                        <span style="font-weight:bold;">{{__('mails.applyModeLabel')}}</span>
                        <span>
                            @if( $remjob->apply_email == null )
                                {{ $remjob->apply_link }}
                            @else
                                {{ $remjob->apply_email }}
                            @endif
                        </span>
                    </p>

                </div>

            </div>

            <div class="col-lg-3 col-sm-12">
                <div class="card bg-light pb-2">
                    <div class="card-body text-center">

                        @if( $remjob->company->logo != null and $remjob->plan->show_logo )
                            <img src="{{ asset('storage/' . $remjob->company->logo ) }}" alt="{{ Str::of( $remjob->company->name )->substr(0, 1) }}" width="60" height=auto>
                        @else
                            <img src="{{ asset('storage/logos/nologo.png') }}" alt="Remote Positions" class="w-50" >
                        @endif

                    </div>
                </div>

                <p>
                    <span style="font-weight:bold;">{{__('mails.planLabel')}}</span>
                    <span>{{ $remjob->plan->name }}</span>
                </p>

            </div>

            <div class="d-flex justify-content-between mt-5">

                <p>{{__('mails.finalMsg')}}</p>

            </div>

        </div>

    </div>

