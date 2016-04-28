<?php
namespace Kr\OAuthServerBundle\Command;

use Kr\OAuthServerBundle\Manager\ClientManager;
use Kr\OAuthServerBundle\Model\ClientInterface;
use Kr\OAuthServerBundle\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ClientListCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("oauth-server:client:list")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        /** @var ClientManager $clientManager */
        $clientManager   = $this->getContainer()->get("kr.oauth_server.manager.client");

        /** @var ClientInterface[] $clients */
        $clients = $clientManager->getRepository()->findAll();
        $rows = [];

        foreach($clients as $client)
        {
            $username = "";
            if($client->getUser()) {
                $username = $client->getUser()->getUsername();
            }
            $rows[] = [$client->getId(), $client->getSecret(), $username];
        }
        $io->table(["id", "secret", "user"], $rows);
    }
}

