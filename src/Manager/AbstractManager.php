<?php
namespace Kr\OAuthServerBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Kr\OAuthServerBundle\Manager\Factory\FactoryInterface;
use Kr\OAuthServerBundle\Model\TokenInterface;

abstract class AbstractManager
{
    /** @var EntityManager  */
    protected $entityManager;

    /** @var FactoryInterface */
    protected $factory;

    /** @var EntityRepository  */
    protected $repository;

    public function __construct(EntityManager $entityManager, FactoryInterface $factory, $className)
    {
        $this->entityManager    = $entityManager;
        $this->factory          = $factory;
        $this->className        = $className;
        $this->repository       = $entityManager->getRepository($className);
    }

    /**
     * Returns the classname of the managed object
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Returns the repository for the managed object
     *
     * @return EntityRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }
}