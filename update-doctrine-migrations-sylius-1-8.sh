#!/bin/bash

bin/console doctrine:migrations:sync-metadata-storage

bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20161202011555" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20161209095131" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20161214153137" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20161215103325" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20161219160441" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20161220092422" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20161221133514" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20161223091334" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20161223164558" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170103120334" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170109143010" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170110120125" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170116215417" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170117075436" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170120164250" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170124221955" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170201094058" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170206122839" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170206141520" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170208102345" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170208103250" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170214095710" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170214104908" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170215143031" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170217141621" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170220150813" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170223071604" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170301135010" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170303170201" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170321131352" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170327135945" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170401200415" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170518123056" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170824124122" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20170913125128" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20171003103916" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20180102140039" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20180226142349" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20190109095211" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20190109160409" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20190204092544" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20190416073011" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20190607135638" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20200110132702" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20200122082429" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\CoreBundle\Migrations\Version20200202104152" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\AdminApiBundle\Migrations\Version20161202011556" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\AdminApiBundle\Migrations\Version20170313125424" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\Bundle\AdminApiBundle\Migrations\Version20170711151342" --add --no-interaction

bin/console doctrine:migrations:version "Brille24\SyliusCustomerOptionsPlugin\Migrations\Version20191010092726" --add --no-interaction
bin/console doctrine:migrations:version "Brille24\SyliusCustomerOptionsPlugin\Migrations\Version20191010092727" --add --no-interaction

bin/console doctrine:migrations:version "Sylius\RefundPlugin\Migrations\Version20180704112314" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\RefundPlugin\Migrations\Version20180718125528" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\RefundPlugin\Migrations\Version20180817130113" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\RefundPlugin\Migrations\Version20180820132147" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\RefundPlugin\Migrations\Version20180829090832" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\RefundPlugin\Migrations\Version20190207125150" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\RefundPlugin\Migrations\Version20190215154028" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\RefundPlugin\Migrations\Version20190517064223" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\RefundPlugin\Migrations\Version20190928200659" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\RefundPlugin\Migrations\Version20191217075815" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\RefundPlugin\Migrations\Version20191230121402" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\RefundPlugin\Migrations\Version20200113091731" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\RefundPlugin\Migrations\Version20200125182414" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\RefundPlugin\Migrations\Version20200131082149" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\RefundPlugin\Migrations\Version20200304172851" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\RefundPlugin\Migrations\Version20200306145439" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\RefundPlugin\Migrations\Version20200306153205" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\RefundPlugin\Migrations\Version20200310094633" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\RefundPlugin\Migrations\Version20200310185620" --add --no-interaction

for file in $(ls -1 src/Migrations/ | sed -e 's/\..*$//')
do
    bin/console doctrine:migrations:version "DoctrineMigrations\\${file}" --add --no-interaction
done
