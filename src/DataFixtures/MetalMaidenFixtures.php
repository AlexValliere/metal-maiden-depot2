<?php

namespace App\DataFixtures;

use App\DataFixtures\AttireCategoryFixtures;
use App\Entity\AttireCategory;
use App\Entity\MetalMaiden;
use App\Entity\Nation;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MetalMaidenFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->loadMetalMaidens($manager);
    }

    public function getDependencies()
    {
        return array(
            AttireCategoryFixtures::class,
        );
    }

    private function loadMetalMaidens(ObjectManager $manager)
    {
    	$i = 0;

        foreach ($this->getMetalMaidenData() as [$name, $attire, $attireCategoryAbbreviation, $nationName]) {
            $metalMaiden = new MetalMaiden();
            $metalMaiden->setName($name);
            $metalMaiden->setAttire($attire);
            $metalMaiden->setAttireCategory($this->getReference('attire_category-' . $attireCategoryAbbreviation));
            $metalMaiden->setNation($this->getReference('nation-' . $nationName));

            $manager->persist($metalMaiden);
            $this->addReference('metal_maiden-' . $i++, $metalMaiden);
        }

        $manager->flush();
    }

    private function getMetalMaidenData(): array
    {
        return [
            // $metalMaidenData = [$name, $attire, $attireCategoryAbbreviation, $nationName];
            ['Lyudmila · Levichenko', '2B1 Oka SPA', 'SPG', 'Rossiya'],
            ['Edith Salet', 'Chatillon 25t', 'MT', 'Gallia'],
            ['Mavis Fischer', 'Sturmgeschütz IV', 'ATG', 'Bavaria'],
            ['Maya Klein', '38 (T) Tank Ausf. G', 'LT', 'Bavaria'],
            ['Lasia Cruz', 'M6A1 Heavy Tank', 'HT', 'Freedonia'],
        ];
    }
}
