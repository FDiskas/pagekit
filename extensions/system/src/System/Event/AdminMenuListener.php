<?php

namespace Pagekit\System\Event;

use Pagekit\Framework\Event\EventSubscriber;
use Pagekit\Menu\Event\MenuEvent;
use Pagekit\System\Menu\Item;

class AdminMenuListener extends EventSubscriber
{
    /**
     * Adds extensions menu items.
     */
    public function onAdminMenu(MenuEvent $event)
    {
        $menu = $event->getMenu();

        foreach ($this('extensions') as $extension) {
            foreach ($extension->getConfig('menu', array()) as $id => $properties) {

                $properties['parentId'] = isset($properties['parent']) ? $properties['parent'] : 0;
                unset($properties['parent']);

                $menu->addItem(new Item(array_merge($properties, array('id' => $id, 'name' => isset($properties['label']) ? $properties['label'] : $id, 'menu' => $menu))));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            'system.admin_menu' => 'onAdminMenu'
        );
    }
}