<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Blog;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=20; $i++) {
            $blog = new Blog;
            $blog->setTitle("Blog $i");
            $blog->setContent("This is my new blog about programming");
            $blog->setDate(\DateTime::createFromFormat("Y/m/d", "2022/05/18"));
            $manager->persist($blog);
        }

        $manager->flush();
    }
}
