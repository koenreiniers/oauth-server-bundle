<?php
namespace Kr\OAuthServerBundle\Manager\Factory;

interface FactoryInterface
{
    /**
     * @param string $className
     *
     * @return object
     */
    public function create($className);
}