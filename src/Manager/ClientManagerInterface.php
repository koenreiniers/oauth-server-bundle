<?php
namespace Kr\OAuthServerBundle\Manager;

use Kr\OAuthServerBundle\Model\ClientInterface;

interface ClientManagerInterface extends ManagerInterface
{
    /**
     * Returns a new client instance
     *
     * @return ClientInterface
     */
    public function createClient();

    /**
     * Saves the client
     *
     * @param ClientInterface $client
     */
    public function saveClient(ClientInterface $client);

    /**
     * Removes a single client
     *
     * @param ClientInterface $client
     */
    public function removeAuthorizationCode(ClientInterface $client);
}