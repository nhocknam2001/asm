<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $student = new Student();
            $student->setName("Student $i");
            $student->setBirthday(\DateTime::createFromFormat('Y-m-d', '1999-05-08'));
            $student->setAddress("HaNoi");
            $student->setAvatar("student.jpg");

            $manager->persist($student);
        }

        $manager->flush();
    }
}
