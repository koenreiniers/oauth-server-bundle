<?php
namespace Kr\OAuthServerBundle\Command;

use Kr\OAuthServerBundle\Model\ClientInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClientAddUriCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("oauth-server:client:add-uri")
            ->addArgument("client_id", InputArgument::REQUIRED)
            ->addArgument("redirect_uri", InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientRepository   = $this->getContainer()->get("kr.oauth_server.repository.client");
        $clientManager      = $this->getContainer()->get("kr.oauth_server.manager.client");

        $clientId       = $input->getArgument("client_id");
        $redirectUri    = $input->getArgument("redirect_uri");

        /** @var ClientInterface $client */
        $client = $clientRepository->find($clientId);
        if(!$client) {
            throw new \Exception("Client with id $clientId does not exist. You can view the list of clients through oauth-server:client:list.");
        }

        $client->addRedirectUri($redirectUri);
        $clientManager->saveClient($client);

        $output->writeln("Redirect uri has been added");
    }
}

