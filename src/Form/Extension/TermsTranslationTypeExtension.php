<?php

declare(strict_types=1);

namespace App\Form\Extension;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Setono\SyliusTermsPlugin\Form\Type\TermsTranslationType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class TermsTranslationTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->remove('content')
            ->add('content', CKEditorType::class, [
                'required' => false,
                'label' => 'setono_sylius_terms.form.terms.content',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public static function getExtendedTypes(): iterable
    {
        return [TermsTranslationType::class];
    }
}
