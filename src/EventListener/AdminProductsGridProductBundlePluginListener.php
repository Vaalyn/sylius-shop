<?php

declare(strict_types=1);

namespace App\EventListener;

use Sylius\Component\Grid\Event\GridDefinitionConverterEvent;

class AdminProductsGridProductBundlePluginListener
{
    public function addProductBunldeMainAction(GridDefinitionConverterEvent $event)
    {
        $links = [
            'bundle' => [
                'label' => 'bitbag_sylius_product_bundle.ui.bundle',
                'icon' => 'plus',
                'route' => 'bitbag_product_bundle_admin_product_create_bundle',
            ],
        ];

        $action = $event->getGrid()->getActionGroup('main')->getAction('create');

        $options = $action->getOptions();

        $options['links'] = array_merge($options['links'], $links);

        $action->setOptions($options);
    }
}
