<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Human;
use AppBundle\Entity\Pet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        $ruts = self::getRuts();

        foreach ($ruts as $i => $rut) {
            $human = new Human();
            $human->setRut($rut);
            $human->setFirstname($faker->unique()->firstname);
            $human->setLastname($faker->unique()->lastname);

            $manager->persist($human);
            $manager->flush();

            $this->addReference(sprintf('human_%s', $i), $human);
        }

        foreach ($ruts as $i => $rut) {
            $pet = new Pet();

            $pet->setChip($faker->unique()->randomDigit());
            $pet->setType(rand(1, 6));
            $pet->setFirstname($faker->firstname());
            $pet->setLastname($faker->lastname());
            $pet->setGender((boolean)rand(1,2));
            $pet->setColor($faker->name());
            $pet->setBirthdate(new \DateTime('now'));
            $pet->setKind($faker->name());
            $pet->setSteril((boolean)rand(1,2));
            $pet->setObservations($faker->text());

            $pet->setHuman($this->getReference(sprintf('human_%s', $i)));
            $manager->persist($pet);
        }
        $manager->flush();

    }

    public static function getRuts() {
        return array(
            '13385114-3',
            '6969808-5',
            '17446585-1',
            '12940333-0',
            '24701123-4',
            '5866815-k',
            '6244728-1',
            // '23084652-9',
            // '24772635-7',
            // '21253879-5',
            // '17935783-6',
            // '5587381-k',
            // '21407190-8',
            // '20132008-9',
            // '22381217-1',
            // '13717354-9',
            // '23219465-0',
            // '5588375-0',
            // '18090180-9',
            // '18257690-5',
            // '12545844-0',
            // '15944696-4',
            // '24225297-7',
            // '23434364-5',
            // '19555294-0',
        );
    }
}
