<?php

namespace App\DataFixtures;

use App\Entity\Nation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class NationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadNations($manager);
    }

    private function loadNations(ObjectManager $manager)
    {
    	$i = 0;
        $fileSystem = new Filesystem();

        foreach ($this->getNationData() as [$name]) {
            $nation = new Nation();
            $nation->setName($name);

            $manager->persist($nation);

            $manager->flush();

            $filePath = "public/images/nation2/". $nation->getNameSlug() . ".png";
            $newFilePath = "public/images/nation/". $nation->getNameSlug() . ".png";
            $fileExists = $fileSystem->exists($filePath);

            if ($fileExists)
            {
                $fileSystem->copy($filePath, $newFilePath);
                $portraitImageFile = new UploadedFile($newFilePath, $nation->getNameSlug() . ".png", null, filesize($newFilePath), false, true);
                $nation->setImageFile($portraitImageFile);
                $nation->updateDate();
                $manager->persist($nation);
                $manager->flush();
            }


            $this->addReference('nation-' . $name, $nation);
        }

        // $manager->flush();
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
