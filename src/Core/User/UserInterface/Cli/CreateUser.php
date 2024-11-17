<?php
declare(strict_types=1);

/**
 * File: CreateUser.php
 *
 * @author Łukasz Kilijański <kilijanskilukasz@gmail.com>
 */

namespace App\Core\User\UserInterface\Cli;

use App\Core\User\Application\Command\CreateUser\CreateUserCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Console\Command\Command;

#[AsCommand(
    name: 'app:user:create',
    description: 'Creation of new user'
)]
class CreateUser extends Command
{
    public function __construct(private readonly MessageBusInterface $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->bus->dispatch(new CreateUserCommand(
            $input->getArgument('email')
        ));
        
        $output->writeln('User has been successfully created.');

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this->addArgument('email', InputArgument::REQUIRED);
    }
}