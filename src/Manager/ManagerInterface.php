<?php
namespace Kr\OAuthServerBundle\Manager;

use Kr\OAuthServerBundle\Model\AccessTokenInterface;

interface ManagerInterface
{
    /**
     * Returns the class of the managed objects
     *
     * @return string
     */
    public function getClassName();

    /**
     * Returns the managed objects' repository
     *
     * @param EntityRepository
     */
    public function getRepository();
}