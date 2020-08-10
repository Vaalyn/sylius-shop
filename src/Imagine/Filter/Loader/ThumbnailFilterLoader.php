<?php

namespace App\Imagine\Filter\Loader;

use Imagine\Filter\Basic\Thumbnail;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Liip\ImagineBundle\Imagine\Filter\Loader\LoaderInterface;

/**
 * @todo Remove when LiipImagineBundle uses the ImageInterface::THUMBNAIL_FLAG_NOCLONE
 * @see https://github.com/liip/LiipImagineBundle/issues/894
 *
 */
class ThumbnailFilterLoader implements LoaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ImageInterface $image, array $options = [])
    {
        $mode = ImageInterface::THUMBNAIL_OUTBOUND | ImageInterface::THUMBNAIL_FLAG_NOCLONE;
        if (!empty($options['mode']) && 'inset' === $options['mode']) {
            $mode = ImageInterface::THUMBNAIL_INSET | ImageInterface::THUMBNAIL_FLAG_NOCLONE;
        }

        if (!empty($options['filter'])) {
            $filter = \constant('Imagine\Image\ImageInterface::FILTER_'.mb_strtoupper($options['filter']));
        }
        if (empty($filter)) {
            $filter = ImageInterface::FILTER_UNDEFINED;
        }

        $width = isset($options['size'][0]) ? $options['size'][0] : null;
        $height = isset($options['size'][1]) ? $options['size'][1] : null;

        $size = $image->getSize();
        $origWidth = $size->getWidth();
        $origHeight = $size->getHeight();

        if (null === $width || null === $height) {
            if (null === $height) {
                $height = (int) (($width / $origWidth) * $origHeight);
            } elseif (null === $width) {
                $width = (int) (($height / $origHeight) * $origWidth);
            }
        }

        if (($origWidth > $width || $origHeight > $height)
            || (!empty($options['allow_upscale']) && ($origWidth !== $width || $origHeight !== $height))
        ) {
            $filter = new Thumbnail(new Box($width, $height), $mode, $filter);
            $image = $filter->apply($image);
        }

        return $image;
    }
}
