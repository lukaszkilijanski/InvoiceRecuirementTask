<?php
declare(strict_types=1);

/**
 * File: GetInactiveUsers.php
 *
 * @author Łukasz Kilijański <kilijanskilukasz@gmail.com>
 */

namespace App\Core\User\UserInterface\Cli;

use App\Common\Bus\QueryBusInterface;
use App\Core\User\Application\Query\GetInactiveUsers\GetInactiveUsersQuery;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

#[AsCommand(
    name: 'app:user:get-inactive-users',
    description: 'Get inactive users id'
)]
class GetInactiveUsers extends Command
{
    public function __construct(private readonly QueryBusInterface $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->bus->dispatch(new GetInactiveUsersQuery());

        if(!$users){
            $output->writeln('No users found');
            return Command::SUCCESS;
        }

        foreach($users as $user) {
            $output->writeln((string)$user->id);
        }

        return Command::SUCCESS;
    }
}