<?php

namespace App\DataFixtures;

use App\Entity\AttireCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AttireCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadAttireCategories($manager);
    }

    private function loadAttireCategories(ObjectManager $manager)
    {
    	$i = 0;

        foreach ($this->getAttireCategoryData() as [$abbreviation, $name]) {
            $attireCategory = new AttireCategory();
            $attireCategory->setAbbreviation($abbreviation);
            $attireCategory->setName($name);

            $manager->persist($attireCategory);
            $this->addReference('attire_category-' . $abbreviation, $attireCategory);
        }

        $manager->flush();
    }

    private function getAttireCategoryData(): array
    {
        return [
            // $attireCategoryData = [$abbreviation, $name];
            ['ATG', 'Anti-Gun'],
            ['HT', 'Heavy Tank'],
            ['LAV', 'Light Armored Vehicle'],
            ['LT', 'Light Tank'],
            ['MT', 'Medium Tank'],
            ['SPG', 'Self-Propelled Gun'],
        ];
    }
}
