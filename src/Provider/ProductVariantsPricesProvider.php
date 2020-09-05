<?php

declare(strict_types=1);

namespace App\Provider;

use Sylius\Component\Core\Calculator\ProductVariantPriceCalculatorInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Provider\ProductVariantsPricesProviderInterface;
use Sylius\Component\Product\Model\ProductOptionValueInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class ProductVariantsPricesProvider implements ProductVariantsPricesProviderInterface
{
    /** @var ProductVariantPriceCalculatorInterface */
    private $productVariantPriceCalculator;

    /** @var RepositoryInterface */
    private $taxRateRepository;

    public function __construct(
        ProductVariantPriceCalculatorInterface $productVariantPriceCalculator,
        RepositoryInterface $taxRateRepository
    ) {
        $this->productVariantPriceCalculator = $productVariantPriceCalculator;
        $this->taxRateRepository = $taxRateRepository;
    }

    public function provideVariantsPrices(ProductInterface $product, ChannelInterface $channel): array
    {
        $variantsPrices = [];

        /** @var ProductVariantInterface $variant */
        foreach ($product->getVariants() as $variant) {
            $variantsPrices[] = $this->constructOptionsMap($variant, $channel);
        }

        return $variantsPrices;
    }

    private function constructOptionsMap(ProductVariantInterface $variant, ChannelInterface $channel): array
    {
        $optionMap = [];

        /** @var ProductOptionValueInterface $option */
        foreach ($variant->getOptionValues() as $option) {
            $optionMap[$option->getOptionCode()] = $option->getCode();
        }

        $optionMap['value'] = $this->productVariantPriceCalculator->calculate($variant, ['channel' => $channel]);
        $optionMap['variant'] = $variant;

        return $optionMap;
    }
}
