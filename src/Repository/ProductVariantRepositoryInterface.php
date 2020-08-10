<?php

declare(strict_types=1);

namespace App\Repository;

use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface as BaseProductVariantRepositoryInterface;

interface ProductVariantRepositoryInterface extends BaseProductVariantRepositoryInterface
{
    public function findOneByVariantCode(string $variantCode): ?ProductVariantInterface;
}
