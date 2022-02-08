<?php

namespace App\View\Components;

use App\Models\Hospital;
use Illuminate\View\Component;

class HospitalSelector extends Component
{
    public $url;
    public $hospitals;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->url          = $url;
        $this->hospitals    = Hospital::all();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.hospital-selector');
    }
}
