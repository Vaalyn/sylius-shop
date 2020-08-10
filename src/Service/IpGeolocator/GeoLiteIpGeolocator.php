<?php

declare(strict_types=1);

namespace App\Service\IpGeolocator;

class GeoLiteIpGeolocator extends AbstractIpGeolocator
{
    public function getDatabasePath(): string
    {
        return $this->getBaseDirectory() . '/GeoLite2-Country.mmdb';
    }
}
