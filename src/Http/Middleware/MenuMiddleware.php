<?php

namespace Wislem\Berrier\Http\Middleware;

use Closure;
use Menu;

class MenuMiddleware
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure                  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $access = \Session::get('access');

        Menu::make('main', function($menu) use ($access) {
            $menu->add('Dashboard', 'admin')->prepend('<i class="fa fa-sitemap"></i> <span>')->append('</span>');
            $cms = $menu->add('CMS', ['class' => 'treeview'])->prepend('<i class="fa fa-edit"></i> <span>')->append('</span><i class="fa fa-angle-left pull-right"></i>');
                if($access === 2 or ($access == 1 and config('berrier.permissions.modules.pages') == 'mod:1')) {
                    $cms->add('Pages', 'admin/pages')->active('/admin/pages/*');
                }
                if($access === 2 or ($access == 1 and config('berrier.permissions.modules.posts') == 'mod:1')) {
                    $cms->add('Posts', 'admin/posts')->active('/admin/posts/*');
                }
                if($access === 2 or ($access == 1 and config('berrier.permissions.modules.categories') == 'mod:1')) {
                    $cms->add('Categories', 'admin/categories')->active('admin/categories/*');
                }

            if($access === 2 or ($access == 1 and config('berrier.permissions.modules.widgets') == 'mod:1')) {
                $blocks = $menu->add('Blocks', ['class' => 'treeview'])->prepend('<i class="fa fa-cubes"></i> <span>')->append('</span><i class="fa fa-angle-left pull-right"></i>');
                    $blocks->add('Menus', 'admin/menus')->active('/admin/menus/*');
                    $blocks->add('Widgets', 'admin/widgets')->active('/admin/widgets/*');
                $blocks->divide();
            }else {
                $cms->divide();
            }

            if($access === 2 or ($access == 1 and config('berrier.permissions.modules.users') == 'mod:1')) {
                $menu->add('Users', ['class' => 'treeview'])->prepend('<i class="fa fa-users"></i> <span>')->append('</span><i class="fa fa-angle-left pull-right"></i>');
                    $menu->users->add('Manage Users', 'admin/users')->active('admin/users/*');
                    $menu->users->add('Global user settings', 'admin/usettings')->active('admin/usettings/*');
            }

            if($access === 2 or ($access == 1 and config('berrier.permissions.modules.settings') == 'mod:1')) {
                $menu->add('Settings', 'admin/settings')->active('admin/settings/*')->prepend('<i class="fa fa-gears"></i> <span>')->append('</span>')->divide();
            }
        });

        return $next($request);
    }
}