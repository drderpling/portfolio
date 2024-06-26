<?php

declare(strict_types=1);

namespace App\Modules\Navigation\Providers;

use App\Modules\Navigation\Livewire\Navigation\History;
use App\Modules\Navigation\Livewire\Navigation\LinkGroup;
use App\Modules\Navigation\Livewire\Navigation\LinkItem;
use App\Modules\Navigation\View\Components\MobileSidebar;
use App\Modules\Navigation\View\Components\Sidebar;
use App\Modules\Navigation\View\Components\TopBar;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class NavigationProvider extends ServiceProvider
{
    public function boot(): void
    {
        Livewire::component('navigation.components.link-group', LinkGroup::class);
        Livewire::component('navigation.components.link-item', LinkItem::class);
        Livewire::component('navigation.components.history', History::class);
        Blade::component(TopBar::class, 'top-bar', 'navigation');
        Blade::component(Sidebar::class, 'sidebar', 'navigation');
        Blade::component(MobileSidebar::class, 'mobile-sidebar', 'navigation');
    }
}
