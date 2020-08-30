<?php

declare(strict_types=1);

namespace App\Entity\Order;

use BitBag\SyliusProductBundlePlugin\Entity\ProductBundleOrderItemInterface;
use BitBag\SyliusProductBundlePlugin\Entity\ProductBundleOrderItemsAwareTrait;
use Brille24\SyliusCustomerOptionsPlugin\Entity\OrderItemInterface as ProductCustomerOptionOrderItemInterface;
use Brille24\SyliusCustomerOptionsPlugin\Traits\OrderItemCustomerOptionCapableTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\OrderItem as BaseOrderItem;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_order_item")
 */
class OrderItem extends BaseOrderItem implements ProductCustomerOptionOrderItemInterface
{
    use ProductBundleOrderItemsAwareTrait;
    use OrderItemCustomerOptionCapableTrait {
        __construct as protected customerOptionCapableConstructor;
    }

    /**
     * @ORM\OneToMany(targetEntity="BitBag\SyliusProductBundlePlugin\Entity\ProductBundleOrderItemInterface", mappedBy="orderItem", cascade={"all"})
     *
     * @var ArrayCollection|ProductBundleOrderItemInterface[]
     */
    protected $productBundleOrderItems;

    public function __construct()
    {
        parent::__construct();

        $this->customerOptionCapableConstructor();
    }
}
