<?php

namespace App\Twig;

use Symfony\Component\Intl\Intl;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $localeCodes;
    private $locales;

    public function __construct($locales)
    {
        $this->localeCodes = explode('|', $locales);
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('locales', [$this, 'getLocales']),
        ];
    }

    /**
     * Takes the list of codes of the locales (languages) enabled in the
     * application and returns an array with the name of each locale written
     * in its own language (e.g. English, Français, Español, etc.).
     */
    public function getLocales(): array
    {
        if (null !== $this->locales) {
            return $this->locales;
        }

        $this->locales = [];
        foreach ($this->localeCodes as $localeCode) {
            $this->locales[] = ['code' => $localeCode, 'name' => Intl::getLocaleBundle()->getLocaleName($localeCode, $localeCode)];
        }

        return $this->locales;
    }

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