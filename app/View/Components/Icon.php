<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Icon extends Component
{
    public $name;

    public $width;

    public $height;

    public $class;

    public function __construct($name, $width = 24, $height = 24, $class = '')
    {
        $this->name = $name;
        $this->width = $width;
        $this->height = $height;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.ui.icon');
    }
}
