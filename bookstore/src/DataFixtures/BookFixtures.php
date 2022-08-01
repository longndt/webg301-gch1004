<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=20; $i++) {
            $book = new Book;
            $book->setTitle("Book $i")
                 ->setQuantity(rand(10,100))
                 ->setImage("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRjwR_qwwP-PgM2uGa5crh8YvIhpV_yc7LNXA&usqp=CAU")
                 ->setPrice((float)(rand(10,100)))
                 ->setDate(\DateTime::createFromFormat('Y-m-d','2020-05-25'));
            $manager->persist($book);
        }

        $manager->flush();
    }
}
