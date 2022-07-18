<?php

namespace App\DataFixtures;

use App\Entity\Mobile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MobileFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=10; $i<=20; $i++) {
            $mobile = new Mobile;
            $mobile->setName("Mobile $i");
            $mobile->setQuantity(rand(5,30));
            $mobile->setPrice((float)(rand(500,1500)));
            $mobile->setBestseller(true);
            $mobile->setImage("https://c8n8e4j6.rocketcdn.me/wp-content/uploads/2021/09/iPhone-13-Pro-iPhone-13-Pro-Max-9.jpg");
            $manager->persist($mobile);
        }

        $manager->flush();
    }
}
