<?php
namespace Kr\OAuthServerBundle\Manager;

use Kr\OAuthServerBundle\Model\AuthorizationCodeInterface;

class AuthorizationCodeManager extends AbstractManager implements AuthorizationCodeManagerInterface
{
    /**
     * @inheritdoc
     */
    public function createAuthorizationCode()
    {
        return $this->factory->create($this->getClassName());
    }

    /**
     * @inheritdoc
     */
    public function saveAuthorizationCode(AuthorizationCodeInterface $authorizationCode)
    {
        $this->entityManager->persist($authorizationCode);
        $this->entityManager->flush();
    }

    /**
     * @inheritdoc
     */
    public function removeAuthorizationCode(AuthorizationCodeInterface $authorizationCode)
    {
        $this->entityManager->remove($authorizationCode);
        $this->entityManager->flush();
    }
}