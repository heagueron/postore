<?php

namespace App\View\Components;

use App\Spost;
use Illuminate\View\Component;

class SpostItem extends Component
{
    public $spost;
    public $mode;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Spost $spost, $mode)
    {
        $this->spost = $spost;
        $this->mode  = $mode;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.spost-item');
    }
}
