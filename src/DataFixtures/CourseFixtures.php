<?php

namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i < 20; $i++) {

            $course = new Course();
            $course-> setName("Course $i");
            $course-> setGrade(rand(50,100));

            $manager->persist($course);
        }

        $manager->flush();
    }
}
