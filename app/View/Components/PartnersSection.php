<?php

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class PartnersSection extends Component
{
    public function __construct(
        public Collection $clients,
        public string $label = 'Нам доверяют',
        public string $title = 'Наши партнёры'
    ) {}

    public function render()
    {
        return view('components.sections.partners');
    }
}
