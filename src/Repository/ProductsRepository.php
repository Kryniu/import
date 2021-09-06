<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Products::class);
    }

    public function add(Products $products)
    {
        $this->entityManager->persist($products);
    }

    public function save()
    {
        $this->entityManager->flush();
    }

    /** @return Products[] */
    public function findAllByIndex(): array
    {
        return $this->createQueryBuilder('p', 'p.index')
            ->getQuery()
            ->getResult();
    }
}
