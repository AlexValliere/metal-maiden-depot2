<?php

namespace App\DataFixtures;

use App\Entity\Nation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class NationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadNations($manager);
    }

    private function loadNations(ObjectManager $manager)
    {
    	$i = 0;

        foreach ($this->getNationData() as $name) {
            $nation = new Nation();
            $nation->setName($name);

            $manager->persist($nation);
            $this->addReference('nation-' . $name);
        }

        $manager->flush();
    }

    private function getNationData(): array
    {
        return [
			// $nationData = [$name];
			['Bavaria'],
			['Britannia'],
			['China'],
			['Freedonia'],
			['Fusang'],
			['Gallia'],
			['Rossiya'],
			['Stardust Farer'],
			['Stivalia'],
			['Sweden'],
			['National Flag-08'],
			['National Flag-11'],
        ];
    }
}
