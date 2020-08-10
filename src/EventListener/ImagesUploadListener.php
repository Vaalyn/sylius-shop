<?php

declare(strict_types=1);

namespace App\EventListener;

use Enqueue\Client\ProducerInterface;
use Liip\ImagineBundle\Async\Commands;
use Liip\ImagineBundle\Async\ResolveCache;
use Psr\Log\LoggerInterface;
use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Core\Model\ImagesAwareInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

final class ImagesUploadListener
{
    /** @var ProducerInterface */
    private $producer;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(ProducerInterface $producer, LoggerInterface $logger)
    {
        $this->producer = $producer;
        $this->logger = $logger;
    }

    public function produceLiipImagineResolveAllCacheMessages(GenericEvent $event): void
    {
        $subject = $event->getSubject();
        Assert::isInstanceOf($subject, ImagesAwareInterface::class);

        $this->produceImageMessages($subject);
    }

    private function produceImageMessages(ImagesAwareInterface $subject): void
    {
        $images = $subject->getImages();

        $this->logger->info('Found ' . count($images) . ' images in event');

        /** @var ImageInterface $image */
        foreach ($images as $image) {
            if (null !== $image->getPath()) {
                $this->logger->info('Producing Message for Image with path: ' . $image->getPath());

                $this->producer->sendCommand(
                    Commands::RESOLVE_CACHE,
                    new ResolveCache($image->getPath())
                );
            }
        }
    }
}
