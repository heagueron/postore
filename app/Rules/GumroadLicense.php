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

        // Grab remote job and its permalink
        $remjob = Remjob::find( session('newRemjobId') );

        $license = Gumroad::verifyLicense( $value, $remjob->gumroad_link );

        return
                $license['success'] &&
                $license['uses'] == 1 &&
                !$license['purchase']['refunded'] &&
                !$license['purchase']['disputed'] &&
                !$license['purchase']['chargebacked'];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The provided license is invalid or has expired.';
    }
    
}
