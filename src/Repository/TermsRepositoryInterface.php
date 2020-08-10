<?php

declare(strict_types=1);

namespace App\Repository;

use Setono\SyliusTermsPlugin\Model\TermsInterface;
use Sylius\Component\Channel\Model\ChannelInterface;
use Setono\SyliusTermsPlugin\Doctrine\ORM\TermsRepositoryInterface as BaseTermsRepositoryInterface;

interface TermsRepositoryInterface extends BaseTermsRepositoryInterface
{
    /**
     * @param ChannelInterface $channel
     * @param string $code
     *
     * @return TermsInterface|null
     */
    public function findOneByChannelAndCode(ChannelInterface $channel, string $code): ?TermsInterface;
}
