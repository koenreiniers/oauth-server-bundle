<?php
namespace Kr\OAuthServerBundle\Manager;

use Kr\OAuthServerBundle\Model\RefreshTokenInterface;

class RefreshTokenManager extends AbstractManager implements RefreshTokenManagerInterface
{
    /**
     * @inheritdoc
     */
    public function createRefreshToken()
    {
        return $this->factory->create($this->getClassName());
    }

    /**
     * @inheritdoc
     */
    public function saveRefreshToken(RefreshTokenInterface $refreshToken)
    {
        $this->entityManager->persist($refreshToken);
        $this->entityManager->flush();
    }

    /**
     * @inheritdoc
     */
    public function removeAuthorizationCode(RefreshTokenInterface $refreshToken)
    {
        $this->entityManager->remove($refreshToken);
        $this->entityManager->flush();
    }

}