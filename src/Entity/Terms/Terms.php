<?php

declare(strict_types=1);

namespace App\Entity\Terms;

use Doctrine\ORM\Mapping as ORM;
use Setono\SyliusTermsPlugin\Model\Terms as BaseTerms;

/**
 * @ORM\Entity
 * @ORM\Table(name="setono_sylius_terms__terms")
 */
class Terms extends BaseTerms
{
}
