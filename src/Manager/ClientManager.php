<?php
namespace Kr\OAuthServerBundle\Manager;

use Kr\OAuthServerBundle\Model\ClientInterface;

class ClientManager extends AbstractManager implements ClientManagerInterface
{
    /**
     * @inheritdoc
     */
    public function createClient()
    {
        $existingIds = $this->getExistingClientIds();
        do {
            $client = $this->factory->create($this->getClassName());
        } while(in_array($client->getId(), $existingIds));

        return $client;
    }

    protected function getExistingClientIds()
    {
        $clients = $this->getRepository()->createQueryBuilder("c")->select("c.id")->getQuery()->getResult();
        $ids = [];
        foreach($clients as $client)
        {
            $ids[] = $client['id'];
        }
        return $ids;

    }

    /**
     * @inheritdoc
     */
    public function saveClient(ClientInterface $client)
    {
        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }

    /**
     * @inheritdoc
     */
    public function removeAuthorizationCode(ClientInterface $client)
    {
        $this->entityManager->remove($client);
        $this->entityManager->flush();
    }
}