<?php

namespace App\Domain\User\Command;

use App\Domain\User\Manager\UserFactory;
use App\Domain\User\UserRoles;
use App\Shared\DTO\UserPOPO;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

// the name of the command is what users type after "php bin/console"
#[AsCommand(
    name: 'app:user-create',
    description: 'Creates a new user.',
    aliases: ['app:user-add'],
    hidden: false
)]
class UserCreateCommand extends Command
{
    public function __construct(private readonly UserFactory $userManager)
    {
        parent::__construct();
    }

    protected function configure(): void

    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to create a user...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        $helper = $this->getHelper('question');
        $question = new Question('Please enter the email of the user [john@doe.com]: ', 'john@doe.com');
        $email = $helper->ask($input, $output, $question);

        $question = new Question('Please enter the password of the user [admin]: ', 'admin');
        $password = $helper->ask($input, $output, $question);

        if (!$helper->ask($input, $output, $question)) {
            return Command::SUCCESS;
        }

        $output->writeln('Username: ' . $email);

        $this->userManager->createUser(
            new UserPOPO(
                email: $email,
                roles: UserRoles::PROFILE_ADMIN,
                password: $password
            )
        );
        $this->userManager->flush();

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}
