<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            new TwigFilter('boolean', array($this, 'booleanFilter')),
        );
    }

    public function booleanFilter($value)
    {
        if ($value) {
            return "Yes";
        } else {
            return "No";
        }
    }
}