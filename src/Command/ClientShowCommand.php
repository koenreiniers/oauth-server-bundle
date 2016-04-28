<?php
namespace Kr\OAuthServerBundle\Command;

use Kr\OAuthServerBundle\Model\ClientInterface;
use Kr\OAuthServerBundle\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ClientShowCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("oauth-server:client:show")
            ->addArgument("client_id", InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientId = $input->getArgument("client_id");
        $io = new SymfonyStyle($input, $output);
        /** @var ClientRepository $clientRepository */
        $clientRepository   = $this->getContainer()->get("kr.oauth_server.repository.client");

        /** @var ClientInterface $clients */
        $client = $clientRepository->find($clientId);

        $rows = [];
        $username = "";
        if($client->getUser()) {
            $username = $client->getUser()->getUsername();
        }
        $grants = implode(", ", $client->getAllowedGrantTypes());
        $redirectUris = implode(", ", $client->getRedirectUris());
        $rows[] = [$client->getId(), $client->getSecret(), $username, $grants, $redirectUris];

        $io->table(["Id", "Secret", "Username", "Allowed grants", "Redirect uris"], $rows);
    }
}

