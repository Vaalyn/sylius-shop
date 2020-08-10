<?php

declare(strict_types=1);

namespace App\Service\IpGeolocator;

use MaxMind\Db\Reader;

interface IpGeolocatorInterface
{
    public function getDatabasePath(): string;

    public function isAvailable(): bool;

    public function getReader(): ?Reader;
}
