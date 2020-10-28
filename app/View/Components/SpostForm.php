<?php

namespace App\View\Components;

use App\Spost;
use Illuminate\View\Component;

class SpostForm extends Component
{
    public $spost;
    public $mode;
    public $user;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Spost $spost, $mode)
    {
        $this->spost = $spost;
        $this->mode  = $mode;
        // $this->user  = auth()->user();
        $this->user  = \App\User::find(1);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.spost-form');
    }
}
