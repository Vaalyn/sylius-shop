<?php

declare(strict_types=1);

namespace App\Service\CacheManager;

use Liip\ImagineBundle\Binary\BinaryInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;

/**
 * @todo Remove after format/extension is fixed
 * @see https://github.com/liip/LiipImagineBundle/issues/1198
 */
class ImageCacheManager extends CacheManager
{
    public function getResultPath($path, $filter)
    {
        $config = $this->filterConfig->get($filter);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $targetExtension = $config['format'] ?? $extension;
        if (
            $extension &&
            $targetExtension &&
            mb_strtolower($targetExtension, 'UTF-8') !== mb_strtolower($extension, 'UTF-8')
        ) {
            $path = mb_substr($path, 0, -mb_strlen($extension, 'UTF-8'), 'UTF-8') . $targetExtension;
        }
        return $path;
    }

    public function store(BinaryInterface $binary, $path, $filter, $resolver = null)
    {
        $path = $this->getResultPath($path, $filter);
        parent::store($binary, $path, $filter, $resolver);
    }

    public function resolve($path, $filter, $resolver = null)
    {
        $path = $this->getResultPath($path, $filter);
        return parent::resolve($path, $filter, $resolver);
    }

    public function isStored($path, $filter, $resolver = null)
    {
        $path = $this->getResultPath($path, $filter);
        return parent::isStored($path, $filter, $resolver);
    }
}
