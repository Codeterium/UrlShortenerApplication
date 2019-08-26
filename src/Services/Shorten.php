<?php

namespace App\Services;

use Doctrine\ORM\EntityManager;
use App\Entity\Shorten as Model;

class Shorten
{
    /**
     * Entity Manager
     * @var Doctrine\ORM\EntityManager
     */
    private $em;

    function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Create new shorten url
     * @param String $url
     * @return Model
     */
    public function create(String $url = ''): Model
    {
        // Generate new Code
        $code =  $this->getCode();
        $shorten = new Model();
        $shorten->setUrl($url);
        $shorten->setShort($code);
        $this->em->persist($shorten);
        $this->em->flush();
        return $shorten;
    }

    /**
     * Increase visit counter and return redirect url
     * @param String $code shorten code
     * @return Model|null redirect url
     */
    public function counter(String $code = ''): ?Model
    {
        $shortenRepo = $this->em->getRepository(Model::class);
        $shorten = $shortenRepo->findOneBy(['short' => $code]);
        if ($shorten) {
            $visit = $shorten->getVisit() + 1;
            $shorten->setVisit($visit);
            $this->em->persist($shorten);
            $this->em->flush();
            return $shorten;
        }
        return null;
    }

    /**
     * Generate random string
     * @return string
     */
    public function getCode(Int $length = 6): string
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        //remember to declare $bits as an array
        $bits = array();
        //put the length -1 in cache
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $bits[] = $alphabet[$n];
        }
        //turn the array into a string
        return implode($bits);
    }

    /**
     * Try to find entered URL in database
     * @param String $url
     * @return boolean
     */
    public function isExist(String $url): bool
    {
        $shortenRepo = $this->em->getRepository(Model::class);
        $url = $shortenRepo->findOneBy(
            ['url' => $url]
        );
        if ($url) {
            return true;
        }
        return false;
    }

    /**
     * List of Urls
     * @return Array|null
     */
    public function list(): ?array
    {
        return $this->em->getRepository(Model::class)->findAll();
    }
}
