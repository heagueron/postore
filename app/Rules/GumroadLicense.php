<?php

namespace App\Rules;

use App\Remjob;
use App\ApiConnectors\Gumroad;
use Illuminate\Contracts\Validation\Rule;

class GumroadLicense implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if( ( null !== session('newRemjobId') ) and Remjob::where('id', session('newRemjobId') )->exists() ) {
            
            // Grab remote job and its permalink
            $remjob = Remjob::find( session('newRemjobId') );

            $grConnection = new Gumroad();

            $license = $grConnection->verifyLicense( $value, $remjob->plan->gumroad_permalink );

            //$license = Gumroad::verifyLicense( $value, $remjob->gumroad_permalink );

            return
                    $license['success'] &&
                    $license['uses'] == 1 &&
                    !$license['purchase']['refunded'] &&
                    !$license['purchase']['disputed'] &&
                    !$license['purchase']['chargebacked'];

        }

        return false;
        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'There was a problem validating the provided license. Contact support.';
    }
    
}
