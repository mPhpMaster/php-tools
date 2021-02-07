<?php

namespace {@ listener_namespace @};

use App\Events\AdminMenuCreated;
use App\Models\Menu\Menu;
use {@ model_namespace @}\{@ model_name @};

class {@ listener_name @}
{

    /**
     * Handle the event.
     *
     * @param  AdminMenuCreated $event
     * @return void
     */
    public function handle(AdminMenuCreated $event)
    {
        $menus = {@ model_name @}::modelConfig('menus', []);
        Menu::menuResolver($event->menu, $menus);
        return;

        d(
                {@ model_name @}::PermissionName(),
                config("ModelCrud.{@ config_name @}")
        );
    }
}
