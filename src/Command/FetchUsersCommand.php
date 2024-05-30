<?php
declare(strict_types=1);
namespace App\Command;

use App\Service\UserFetcher;
use Symfony\Bundle\FrameworkBundle\Command\AbstractConfigCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class FetchUsersCommand extends AbstractConfigCommand
{
    public function __construct(
        private readonly UserFetcher $userFetcher,
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        parent::configure();

        $this
            ->setName('aszende:users:fetch')
            ->setDescription('Gets users from public api');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $users = $this->userFetcher->getUsers();

            foreach ($users as $user) {
                $output->writeln(sprintf('Fetched user with id %s and name %s', $user->id, $user->name));
            }

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln(sprintf('Command failed with following error: %s', $e->getMessage()));

            return Command::FAILURE;
        }
    }
}
