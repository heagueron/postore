
    
<div style="margin-top:1rem;padding:25px;background-color:#f2f5f3;">

    <a href="{{ url('/') }}" style="display:flex;justify-content:center;align-items: center;">
        <img src="{{ asset('images/remjob.png') }}" alt="RemJob" width="80px;" >
    </a>

    <div style="padding:20px;background-color:#ffffff;margin-top:15px;">
        
        <p style="margin-bottom:10px;margin-left:10px;">{{__('mails.dearCustomer')}}</p>
        <p style="margin-bottom:10px;margin-left:10px;">{{__('mails.updateSalute')}}</p>

        <div style="margin-bottom:10px;margin-left:10px;">
            <div>

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
                <div>
                    <p style="font-weight:bold;">{{__('mails.descriptionLabel')}}</p>
                    <div>{!! $remjob->description !!}</div>

                    @if($remjob->min_salary)
                        <p>
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
                            <span style="font-weight:bold;">{{__('mails.locationLabel')}}</span>
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

            <div>
                <div>
                    <div>

                        @if( $remjob->company->logo != null and $remjob->plan->show_logo )
                            <img src="{{ asset('storage/' . $remjob->company->logo ) }}" alt="{{ Str::of( $remjob->company->name )->substr(0, 1) }}" width="60" height=auto>
                        @else
                            <img src="{{ asset('storage/logos/nologo.png') }}" alt="Remote Positions" width="60" height=auto >
                        @endif

                    </div>
                </div>

                <p>
                    <span style="font-weight:bold;">{{__('mails.planLabel')}}</span>
                    <span>{{ $remjob->plan->name }}</span>
                </p>

            </div>

            <div class="mt-5">

                <p>{{__('mails.ifEditLabel')}}</p>
                
                <a href="{{ url('/remjobs/edit/' . $remjob->id ) }}">
                    <button type="button" style="paddig:15px !important;background-color:#4CAF50;border:none;color:white;font-weight:bold;">{{__('mails.editButton')}}</button>
                </a> 
                
                <p>{{__('mails.finalMsg')}}</p>

            </div>

        </div>
 
    </div> 

</div>


