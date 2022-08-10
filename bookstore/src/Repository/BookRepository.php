<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Book $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Book $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /** 
     * @return Book[] 
    */
    //new books will be displayed first
    public function sortBookByIdDesc()
    {
        return $this->createQueryBuilder('book')
            ->orderBy('book.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function sortBookPriceAsc() {
        return $this->createQueryBuilder('b')
                    ->orderBy('b.price','ASC')
                    ->getQuery()
                    ->getResult()
                    ;
    }

    public function sortBookPriceDesc() {
        return $this->createQueryBuilder('b')
                    ->orderBy('b.price','DESC')
                    ->getQuery()
                    ->getResult()
                    ;
    }

    public function searchBookByTitle($keyword) 
    {
        return $this->createQueryBuilder('book')
            ->andWhere('book.title LIKE :value')
            ->setParameter('value', '%' . $keyword . '%')
            ->orderBy('book.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }
}
