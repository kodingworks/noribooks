<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Illuminate\Http\Request;
use App\Helpers\Menu\Builder;
use App\Helpers\Menu\ModuleAccess;
use App\Actions\Utility\Dashboard\GetSidebarMenuAction;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        // Get Modules
        $sidebarMenu = new GetSidebarMenuAction();
        $modules = $sidebarMenu->handle();

        $builderSidebar = new Builder([
            new ModuleAccess(),
        ]);
        $activeModules = array_values($builderSidebar->transformItems($modules));

        return array_merge(parent::share($request), [
            'modules' =>  $activeModules,
            'admin_data' =>  auth()->check() ? auth()->user() : null,
            'admin_role' =>  auth()->check() ? auth()->user()->getRoleNames() : null,
        ]);
    }
}
