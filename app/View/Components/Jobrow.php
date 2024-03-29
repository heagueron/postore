<?php

namespace App\View\Components;

use App\Remjob;
use Carbon\Carbon;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class Jobrow extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $remjob;
    public $page;

    public function __construct(Remjob $remjob, $page)
    {
        $this->remjob = $remjob;
        $this->page = $page;
        
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
