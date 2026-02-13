<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PasswordInput extends Component
{
    public $name;
    public $label;

    public function __construct($name, $label = null)
    {
        $this->name = $name;
        $this->label = $label;
    }

    public function render()
    {
        return view('components.password-input');
    }
}
