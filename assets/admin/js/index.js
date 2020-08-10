(function($) {
    $(document).ready(() => {
        $('body').on('click', '#vaachar-set-all-variant-prices-default', function(e) {
            let defaultPrice = $('#vaachar-variant-prices-default').val();

            $('#sylius_product_generate_variants_variants div[data-form-collection="item"]').each((index, variantElement) => {
                $(variantElement).find(`input[name$='[price]']`)
                    .val(defaultPrice);
            });
        });

        $('body').on('click', '#vaachar-set-all-variant-original-prices-default', function(e) {
            let defaultOriginalPrice = $('#vaachar-variant-original-prices-default').val();

            $('#sylius_product_generate_variants_variants div[data-form-collection="item"]').each((index, variantElement) => {
                $(variantElement).find(`input[name$='[originalPrice]']`)
                    .val(defaultOriginalPrice);
            });
        });

        $('body').on('click', '#vaachar-set-all-variant-code-prefix', function(e) {
            let codePrefix = $('#vaachar-variant-code-prefix').val();

            $('#sylius_product_generate_variants_variants div[data-form-collection="item"]').each((variantElementIndex, variantElement) => {
                let optionValues = [];

                $(variantElement).find(`div[id$='_optionValues'] .field`).each((fieldIndex, field) => {
                    let selectedOptionValue = $(field).find('select').val();
                    optionValues.push(selectedOptionValue);
                });

                let joinedOptionValues = optionValues.join('_');

                $(variantElement).find(`input[name$='[code]']`)
                    .val(`${codePrefix}${joinedOptionValues}`);
            });
        });

        $('body').on('change', '#sylius_product_generate_variants_shippingCategoryHelper', function(e) {
            let defaultShippingCategory = $(this).val();

            $('#sylius_product_generate_variants_variants div[data-form-collection="item"]').each((index, variantElement) => {
                $(variantElement).find(`select[name$='[shippingCategory]']`)
                    .val(defaultShippingCategory)
                    .change();
            });
        });

        $('body').on('change', '#sylius_product_generate_variants_taxCategoryHelper', function(e) {
            let defaultTaxCategory = $(this).val();

            $('#sylius_product_generate_variants_variants div[data-form-collection="item"]').each((index, variantElement) => {
                $(variantElement).find(`select[name$='[taxCategory]']`)
                    .val(defaultTaxCategory)
                    .change();
            });
        });
    });
})(jQuery);
