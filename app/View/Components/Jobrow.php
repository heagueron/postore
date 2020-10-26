<?php

namespace App\View\Components;

use App\Remjob;
use Illuminate\View\Component;

class Jobrow extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $remjob;
    public $currentTagSet;

    public function __construct(Remjob $remjob)
    {
        $this->remjob = $remjob;
        $this->currentTagSet = 'javascript';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.jobrow');
    }
}
