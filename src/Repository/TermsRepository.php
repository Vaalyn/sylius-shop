<?php

declare(strict_types=1);

namespace App\Repository;

use Setono\SyliusTermsPlugin\Model\TermsInterface;
use Setono\SyliusTermsPlugin\Doctrine\ORM\TermsRepository as BaseTermsRepository;
use Sylius\Component\Channel\Model\ChannelInterface;

class TermsRepository extends BaseTermsRepository implements TermsRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findOneByChannelAndCode(ChannelInterface $channel, string $code): ?TermsInterface
    {
        return $this->createListQueryBuilder()
            ->andWhere(':channel MEMBER OF o.channels')
            ->andWhere('o.code = :code')
            ->setParameter('channel', $channel)
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
