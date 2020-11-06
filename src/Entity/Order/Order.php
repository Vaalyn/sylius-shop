<?php

declare(strict_types=1);

namespace App\Entity\Order;

use BitBag\SyliusMolliePlugin\Entity\OrderInterface;
use BitBag\SyliusMolliePlugin\Entity\OrderTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Order as BaseOrder;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_order")
 */
class Order extends BaseOrder implements OrderInterface
{
    use OrderTrait;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected  $abandonedEmail = false;
}
