<?php

declare(strict_types=1);

namespace App\Form\Extension;

use Sylius\Bundle\ProductBundle\Form\Type\ProductGenerateVariantsType;
use Sylius\Bundle\ShippingBundle\Form\Type\ShippingCategoryChoiceType;
use Sylius\Bundle\TaxationBundle\Form\Type\TaxCategoryChoiceType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductGenerateVariantsTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('shippingCategoryHelper', ShippingCategoryChoiceType::class, [
            'mapped' => false,
            'required' => false,
            'placeholder' => 'sylius.ui.no_requirement',
            'label' => 'sylius.form.product_variant.shipping_category',
        ]);

        $builder->add('taxCategoryHelper', TaxCategoryChoiceType::class, [
            'mapped' => false,
            'required' => false,
            'placeholder' => 'sylius.ui.no_requirement',
            'label' => 'sylius.form.product_variant.tax_category',
        ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [ProductGenerateVariantsType::class];
    }
}

