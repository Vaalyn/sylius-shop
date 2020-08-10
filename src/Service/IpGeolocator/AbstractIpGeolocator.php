<?php

declare(strict_types=1);

namespace App\Service\IpGeolocator;

use MaxMind\Db\Reader;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

abstract class AbstractIpGeolocator implements IpGeolocatorInterface
{
    /** @var string $projectDirectoryPath */
    protected $projectDirectoryPath;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->projectDirectoryPath = $parameterBag->get('kernel.project_dir');
    }

    public function getBaseDirectory(): string
    {
        return $this->projectDirectoryPath . '/data/geoip';
    }

    public function isAvailable(): bool
    {
        return file_exists($this->getDatabasePath());
    }

    public function getReader(): ?Reader
    {
        if (!$this->isAvailable()) {
            return null;
        }

        return new Reader($this->getDatabasePath());
    }
}
