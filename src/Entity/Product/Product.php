<?php

declare(strict_types=1);

namespace App\Entity\Product;

use BitBag\SyliusProductBundlePlugin\Entity\ProductBundlesAwareInterface;
use BitBag\SyliusProductBundlePlugin\Entity\ProductBundlesAwareTrait;
use Brille24\SyliusCustomerOptionsPlugin\Entity\ProductInterface as ProductCustomerOptionProductInterface;
use Brille24\SyliusCustomerOptionsPlugin\Traits\ProductCustomerOptionCapableTrait;
use Doctrine\ORM\Mapping as ORM;
use JoppeDc\SyliusBetterSeoPlugin\Entity\HasSeoInterface;
use JoppeDc\SyliusBetterSeoPlugin\Entity\Traits\SeoTrait;
use MonsieurBiz\SyliusSearchPlugin\Model\Document\Result;
use MonsieurBiz\SyliusSearchPlugin\Model\Documentable\DocumentableInterface;
use MonsieurBiz\SyliusSearchPlugin\Model\Documentable\DocumentableProductTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;
use Sylius\Component\Product\Model\ProductTranslationInterface;
use VaaChar\SyliusFeaturedProductsPlugin\Entity\HasFeaturedProductInterface;
use VaaChar\SyliusFeaturedProductsPlugin\Entity\Traits\FeaturedProductTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product")
 */
class Product extends BaseProduct implements ProductBundlesAwareInterface, DocumentableInterface, HasSeoInterface, ProductCustomerOptionProductInterface, HasFeaturedProductInterface
{
    use ProductBundlesAwareTrait;
    use DocumentableProductTrait;
    use DocumentableProductTrait {
        convertToDocument as protected traitConvertToDocument;
    }
    use SeoTrait;
    use ProductCustomerOptionCapableTrait {
        __construct as protected customerOptionCapableConstructor;
    }
    use FeaturedProductTrait;

    /**
     * @ORM\OneToOne(targetEntity="BitBag\SyliusProductBundlePlugin\Entity\ProductBundleInterface", mappedBy="product", cascade={"persist"})
     *
     * @var ProductBundleInterface
     */
    protected $productBundle;

    public function __construct()
    {
        parent::__construct();

        $this->customerOptionCapableConstructor();
    }

    protected function createTranslation(): ProductTranslationInterface
    {
        return new ProductTranslation();
    }

    public function convertToDocument(string $locale): Result {
        $document = $this->traitConvertToDocument($locale);

        $document->addAttribute('meta_keywords', 'Meta keywords', [$this->getTranslation($locale)->getMetaKeywords()], $locale, 15);

        return $document;
    }
}
