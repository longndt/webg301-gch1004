<?php

namespace App\DataFixtures;

use App\Entity\Todo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TodoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $todo = new Todo;
            $todo->setTitle("Todo $i");
            $todo->setContent("This is todo content");
            $todo->setImage("https://topdev.vn/blog/wp-content/uploads/2022/02/todo-list.jpg");
            $todo->setDate(\DateTime::createFromFormat("Y/m/d","2022/07/27"));
            $manager->persist($todo);
        }

        $manager->flush();
    }
}
