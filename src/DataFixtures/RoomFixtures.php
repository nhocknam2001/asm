<?php

namespace App\DataFixtures;

use App\Entity\Room;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoomFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i < 20; $i++) {

            $room = new Room();
            $room-> setName("room $i");

            $manager->persist($room);
        }


        $manager->flush();
    }
}
