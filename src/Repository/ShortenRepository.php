<?php

namespace App\Repository;

use App\Entity\Shorten;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Short|null find($id, $lockMode = null, $lockVersion = null)
 * @method Short|null findOneBy(array $criteria, array $orderBy = null)
 * @method Short[]    findAll()
 * @method Short[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShortenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shorten::class);
    }

}
