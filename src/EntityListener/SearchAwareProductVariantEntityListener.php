<?php

declare(strict_types=1);

namespace App\EntityListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use MonsieurBiz\SyliusSearchPlugin\Model\Document\Index\Indexer;
use MonsieurBiz\SyliusSearchPlugin\Model\Documentable\DocumentableInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use VaaChar\SyliusArchivableProductsPlugin\Entity\EntityListener\ProductVariantEntityListener;
use VaaChar\SyliusArchivableProductsPlugin\Entity\IsArchivableProductInterface;

class SearchAwareProductVariantEntityListener extends ProductVariantEntityListener
{
    /** @var Indexer */
    protected $documentIndexer;

    public function __construct(Indexer $documentIndexer)
    {
        $this->documentIndexer = $documentIndexer;
    }

    protected function archiveWhenOutOfStock(
        ProductVariantInterface $productVariant,
        PreUpdateEventArgs $event
    ): void {
        parent::archiveWhenOutOfStock($productVariant, $event);

        /** @var IsArchivableProductInterface $product */
        $product = $productVariant->getProduct();

        if (!$product->getArchiveWhenOutOfStock()) {
            return;
        }

        /** @var DocumentableInterface $product */
        $this->documentIndexer->indexOne($product);
    }
}
