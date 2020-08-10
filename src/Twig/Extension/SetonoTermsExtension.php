<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Repository\TermsRepositoryInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SetonoTermsExtension extends AbstractExtension
{
    /** @var TermsRepositoryInterface */
    protected $termsRepository;

    /** @var ChannelContextInterface */
    protected $channelContext;

    /** @var LocaleContextInterface */
    protected $localeContext;

    public function __construct(
        TermsRepositoryInterface $termsRepository,
        ChannelContextInterface $channelContext,
        LocaleContextInterface $localeContext
    ) {
        $this->termsRepository = $termsRepository;
        $this->channelContext = $channelContext;
        $this->localeContext = $localeContext;
    }

    public function getFunctions()
    {
        $options = ['is_safe' => ['html']];

        return [
            new TwigFunction(
                'setono_localized_terms_slug_for_code',
                [$this, 'setonoLocalizedTermsSlugForCode'],
                $options
            ),
        ];
    }

    public function setonoLocalizedTermsSlugForCode(string $termsCode): string
    {
        $channel = $this->channelContext->getChannel();
        $terms = $this->termsRepository->findOneByChannelAndCode($channel, $termsCode);

        if ($terms === null) {
            return '';
        }

        $localeCode = $this->localeContext->getLocaleCode();
        $termsTranslation = $terms->getTranslation($localeCode);

        return $termsTranslation->getSlug();
    }

    public function getName(): string
    {
        return 'vaachar_setono_terms';
    }
}
