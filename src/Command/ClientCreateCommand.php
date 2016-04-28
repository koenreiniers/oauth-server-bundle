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
use Symfony\Component\VarDumper\VarDumper;

class ClientCreateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("oauth-server:client:create")
            ->addArgument("name", InputArgument::REQUIRED)
            ->addArgument("username", InputArgument::OPTIONAL)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $name = $input->getArgument("name");



        // TODO
        $username = $input->hasArgument("username") ? $input->getArgument("username") : null;

        /** @var ClientManager $clientManager */
        $clientManager   = $this->getContainer()->get("kr.oauth_server.manager.client");

        $client = $clientManager->createClient();
        $client->setName($name);
        $clientManager->saveClient($client);


        $io->success("Client has been created:");
        $io->table(["name", "id", "secret"], [[$client->getName(), $client->getId(), $client->getSecret()]]);
    }
}

