<?php

namespace App\DataFixtures;

use App\Entity\Teacher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeacherFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=20; $i++) {
            $teacher = new Teacher();
            $teacher->setName("Teacher $i");
            $teacher->setBirthday(\DateTime::createFromFormat('Y-m-d', '1999-05-08'));
            $teacher->setAddress("HaNoi");
            $teacher->setAvatar("avatar.jpg");

            $manager->persist($teacher);
        }

        $manager->flush();
    }
}
