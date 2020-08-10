<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Entity\Addressing\Address;
use App\Service\IpGeolocator\IpGeolocatorInterface;
use Sylius\Component\Addressing\Matcher\ZoneMatcherInterface;
use Sylius\Component\Addressing\Model\ZoneMemberInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Calculator\ProductVariantPriceCalculatorInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Model\Scope;
use Sylius\Component\Core\Model\TaxRateInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Sylius\Component\Customer\Context\CustomerContextInterface;
use Sylius\Component\Taxation\Resolver\TaxRateResolverInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TaxRateExtension extends AbstractExtension
{
    /** @var ProductVariantRepository */
    protected $productVariantRepository;

    /** @var CustomerContextInterface $customerContext */
    protected $customerContext;

    /** @var ChannelContextInterface $channelContext */
    protected $channelContext;

    /** @var ZoneMatcherInterface $zoneMatcher */
    protected $zoneMatcher;

    /** @var TaxRateResolverInterface $taxRateResolver */
    protected $taxRateResolver;

    /** @var IpGeolocatorInterface $ipGeolocator */
    protected $ipGeolocator;

    /** @var RequestStack $requestStack */
    protected $requestStack;

    /** @var ProductVariantPriceCalculatorInterface $productVariantPriceCalculator */
    protected $productVariantPriceCalculator;

    public function __construct(
        ProductVariantRepositoryInterface $productVariantRepository,
        CustomerContextInterface $customerContext,
        ChannelContextInterface $channelContext,
        ZoneMatcherInterface $zoneMatcher,
        TaxRateResolverInterface $taxRateResolver,
        IpGeolocatorInterface $ipGeolocator,
        RequestStack $requestStack,
        ProductVariantPriceCalculatorInterface $productVariantPriceCalculator
    ) {
        $this->productVariantRepository = $productVariantRepository;
        $this->customerContext = $customerContext;
        $this->channelContext = $channelContext;
        $this->zoneMatcher = $zoneMatcher;
        $this->taxRateResolver = $taxRateResolver;
        $this->ipGeolocator = $ipGeolocator;
        $this->requestStack = $requestStack;
        $this->productVariantPriceCalculator = $productVariantPriceCalculator;
    }

    public function getFunctions()
    {
        $options = ['is_safe' => ['html']];

        return [
            new TwigFunction(
                'vaachar_product_variant_for_code',
                [$this, 'productVariantForVariantCode'],
                $options
            ),
            new TwigFunction(
                'vaachar_tax_rate_product_variant',
                [$this, 'productVariantTaxRate'],
                $options
            ),
            new TwigFunction(
                'vaachar_option_prices_product_variant',
                [$this, 'productVariantOptionPrices'],
                $options
            ),
            new TwigFunction(
                'vaachar_is_german_small_business_tax_rate',
                [$this, 'isGermanSmallBusinessTaxRate'],
                $options
            ),
        ];
    }

    public function productVariantForVariantCode(string $variantCode): ?ProductVariantInterface
    {
        return $this->productVariantRepository->findOneByVariantCode($variantCode);
    }

    public function productVariantTaxRate(
        ProductVariantInterface $productVariant
    ): ?TaxRateInterface {
        $customerTaxRate = $this->fetchCustomerTaxRateForProductVariant($productVariant);

        if ($customerTaxRate !== null) {
            return $customerTaxRate;
        }

        $geoIpTaxRate = $this->fetchGeoIpTaxRateForProductVariant(
            $productVariant
        );

        if ($geoIpTaxRate !== null) {
            return $geoIpTaxRate;
        }

        return $this->fetchDefaultTaxRateForProductVariant(
            $productVariant
        );
    }

    public function productVariantOptionPrices(
        ProductVariantInterface $productVariant
    ): array {
        $optionMap = [];

        /** @var ProductOptionValueInterface $option */
        foreach ($productVariant->getOptionValues() as $option) {
            $optionMap[$option->getOptionCode()] = $option->getCode();
        }

        $channel = $this->channelContext->getChannel();

        $optionMap['value'] = $this->productVariantPriceCalculator->calculate(
            $productVariant,
            ['channel' => $channel]
        );

        return $optionMap;
    }

    public function isGermanSmallBusinessTaxRate(?TaxRateInterface $taxRate): bool
    {
        if ($taxRate === null) {
            return false;
        }

        $taxRateZone = $taxRate->getZone();

        if (!isset($taxRateZone)) {
            return false;
        }

        /** @var ZoneMemberInterface $taxRateZoneMember */
        foreach ($taxRateZone->getMembers() as $taxRateZoneMember) {
            if ($taxRate->getAmount() === 0.0 && $taxRateZoneMember->getCode() === 'DE') {
                return true;
            }
        }

        return false;
    }

    public function getName(): string
    {
        return 'vaachar_tax_rate';
    }

    protected function fetchCustomerTaxRateForProductVariant(
        ProductVariantInterface $productVariant
    ): ?TaxRateInterface {
        /** @var CustomerInterface $customer */
        $customer = $this->customerContext->getCustomer();
        $customerAddress = isset($customer) ? $customer->getDefaultAddress() : null;

        if ($customerAddress === null) {
            return null;
        }

        $customerTaxZone = $this->zoneMatcher->match($customerAddress, Scope::TAX);

        if ($customerTaxZone === null) {
            return null;
        }

        return $this->taxRateResolver->resolve(
            $productVariant,
            ['zone' => $customerTaxZone]
        );
    }

    protected function fetchGeoIpTaxRateForProductVariant(
        ProductVariantInterface $productVariant
    ): ?TaxRateInterface {
        $request = $this->requestStack->getCurrentRequest();

        if ($request === null) {
            return null;
        }

        $requestClientIp = $request->getClientIp();

        if ($requestClientIp === null) {
            return null;
        }

        $geoIpReader = $this->ipGeolocator->getReader();

        if ($geoIpReader === null) {
            return null;
        }

        $geolocation = $geoIpReader->get($requestClientIp);
        $geolocationCountryCode = $geolocation['country']['iso_code'] ?? null;

        if ($geolocationCountryCode === null) {
            return null;
        }

        $geolocationAddress = new Address();
        $geolocationAddress->setCountryCode($geolocationCountryCode);

        $geolocationTaxZone = $this->zoneMatcher->match($geolocationAddress, Scope::TAX);

        if ($geolocationTaxZone === null) {
            return null;
        }

        return $this->taxRateResolver->resolve(
            $productVariant,
            ['zone' => $geolocationTaxZone]
        );
    }

    protected function fetchDefaultTaxRateForProductVariant(
        ProductVariantInterface $productVariant
    ): ?TaxRateInterface {
        /** @var ChannelInterface */
        $channel = $this->channelContext->getChannel();
        $channelDefaultTaxZone = $channel->getDefaultTaxZone();

        return $this->taxRateResolver->resolve(
            $productVariant,
            ['zone' => $channelDefaultTaxZone]
        );
    }
}
