<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use MonsieurBiz\SyliusSearchPlugin\Entity\Product\FilterableInterface;
use MonsieurBiz\SyliusSearchPlugin\Model\Product\FilterableTrait;
use Sylius\Component\Product\Model\ProductOption as BaseProductOption;
use Sylius\Component\Product\Model\ProductOptionTranslationInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_option")
 */
class ProductOption extends BaseProductOption implements FilterableInterface
{
    use FilterableTrait;

    protected function createTranslation(): ProductOptionTranslationInterface
    {
        return new ProductOptionTranslation();
    }
}
