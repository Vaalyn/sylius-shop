<?php

declare(strict_types=1);

namespace App\Access\Checker;

use Odiseo\SyliusRbacPlugin\Access\Checker\RouteNameCheckerInterface;

final class HardcodedRouteNameChecker implements RouteNameCheckerInterface
{
    public function isAdminRoute(string $routeName): bool
    {
        return
            strpos($routeName, 'sylius_admin') !== false ||
            strpos($routeName, 'sylius_rbac_admin') !== false ||
            strpos($routeName, 'bitbag_sylius_cms_plugin_admin') !== false ||
            strpos($routeName, 'bitbag_sylius_mollie_plugin_admin_mollie_logger') !== false
        ;
    }
}
