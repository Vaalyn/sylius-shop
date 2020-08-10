<?php

declare(strict_types=1);

namespace App\Entity\Order;

use BitBag\SyliusProductBundlePlugin\Entity\ProductBundleOrderItemInterface;
use BitBag\SyliusProductBundlePlugin\Entity\ProductBundleOrderItemsAwareTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\OrderItem as BaseOrderItem;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_order_item")
 */
class OrderItem extends BaseOrderItem
{
    use ProductBundleOrderItemsAwareTrait;

    /**
     * @ORM\OneToMany(targetEntity="BitBag\SyliusProductBundlePlugin\Entity\ProductBundleOrderItemInterface", mappedBy="orderItem", cascade={"all"})
     *
     * @var ArrayCollection|ProductBundleOrderItemInterface[]
     */
    protected $productBundleOrderItems;
}
