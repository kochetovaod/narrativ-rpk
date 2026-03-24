<?php

namespace App\View\Composers;

use App\Helpers\NavigationHelper;
use Illuminate\View\View;

class NavigationComposer
{
    /**
     * Данные для навигации
     */
    protected array $navigationData;

    /**
     * Create a new navigation composer.
     */
    public function __construct()
    {
        $this->navigationData = [
            'navServices' => NavigationHelper::getServices(),
            'navCategories' => NavigationHelper::getProductCategories(),
        ];
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with($this->navigationData);
    }
}
