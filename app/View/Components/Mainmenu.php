<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Mainmenu extends Component
{
    public $menus;

    public function __construct($menus = null)
    {
        $this->menus = $menus;
    }

    public function render(): View|Closure|string
    {
        return view('components.mainmenu');
    }
}
