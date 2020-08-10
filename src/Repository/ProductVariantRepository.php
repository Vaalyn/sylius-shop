<?php

declare(strict_types=1);

namespace App\Repository;

use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductVariantRepository as BaseProductVariantRepository;
use Sylius\Component\Core\Model\ProductVariantInterface;
use BitBag\SyliusProductBundlePlugin\Repository\ProductVariantRepositoryInterface as BitBagProductBundleProductVariantRepositoryInterface;

class ProductVariantRepository extends BaseProductVariantRepository implements BitBagProductBundleProductVariantRepositoryInterface
{
    public function findOneByVariantCode(string $variantCode): ?ProductVariantInterface
    {
        return $this->createQueryBuilder('o')
            ->addSelect('translation')
            ->leftJoin('o.translations', 'translation')
            ->where('o.code = :code')
            ->setParameter('code', $variantCode)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByPhrase(string $phrase, string $locale): array
    {
        $expr = $this->getEntityManager()->getExpressionBuilder();

        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation', 'WITH', 'translation.locale = :locale')
            ->innerJoin('o.product', 'product')
            ->andWhere($expr->orX(
                'translation.name LIKE :phrase',
                'o.code LIKE :phrase',
                'product.code LIKE :phrase'
            ))
            ->setParameter('phrase', '%' . $phrase . '%')
            ->setParameter('locale', $locale)
            ->setMaxResults(20)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByCodes(array $codes): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.code IN (:codes)')
            ->setParameter('codes', $codes)
            ->getQuery()
            ->getResult()
        ;
    }
}
