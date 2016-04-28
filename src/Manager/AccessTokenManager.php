<?php
namespace Kr\OAuthServerBundle\Manager;

use Kr\OAuthServerBundle\Model\AccessTokenInterface;

class AccessTokenManager extends AbstractManager implements AccessTokenManagerInterface
{
    /**
     * @inheritdoc
     */
    public function createAccessToken()
    {
        return $this->factory->create($this->getClassName());
    }

    /**
     * @inheritdoc
     */
    public function saveAccessToken(AccessTokenInterface $accessToken)
    {
        $this->entityManager->persist($accessToken);
        $this->entityManager->flush();
    }

    /**
     * @inheritdoc
     */
    public function removeAccessToken(AccessTokenInterface $accessToken)
    {
        $this->entityManager->remove($accessToken);
        $this->entityManager->flush();
    }
}