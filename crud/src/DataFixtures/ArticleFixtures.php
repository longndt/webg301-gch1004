<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=30; $i++) {
            $article = new Article;
            $article->setTitle("Article $i");
            $article->setAuthor("Vietnam");
            $article->setLength(rand(10,50));
            $article->setDate(\DateTime::createFromFormat("Y/m/d","2022/07/15"));
            $manager->persist($article);
        }
        $manager->flush();
    }
}
