<?php
declare(strict_types=1);

/**
 * File: CreateInvoiceTest.php
 *
 * @author Łukasz Kilijański <kilijanskilukasz@gmail.com>
 */

namespace App\Tests\Unit\Core\Invoice\UserInterface\Cli;

use PHPUnit\Framework\TestCase;
use App\Core\Invoice\UserInterface\Cli\CreateInvoice;
use App\Core\Invoice\Application\Command\CreateInvoice\CreateInvoiceCommand;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Envelope;

class CreateInvoiceTest extends TestCase
{
    private $command;
    private $busMock;
    private $userRepositoryMock;

    protected function setUp(): void
    {
        $this->busMock = $this->createMock(MessageBusInterface::class);
        $this->userRepositoryMock = $this->createMock(UserRepositoryInterface::class);

        // Create the command instance with mocked dependencies
        $this->command = new CreateInvoice($this->busMock, $this->userRepositoryMock);
    }

    public function testExecuteUserIsInactive()
    {
        // Given: a user is inactive
        $email = 'inactive@example.com';
        $amount = 100;
        $this->userRepositoryMock
            ->expects($this->once())
            ->method('checkIfUserIsActiveByEmail')
            ->with($email)
            ->willReturn(false);

        // When: the command is executed
        $commandTester = new CommandTester($this->command);
        $commandTester->execute([
            'email' => $email,
            'amount' => $amount
        ]);

        // Then: the output should indicate that the user is inactive, and the command should fail
        $this->assertStringContainsString('User is inactive', $commandTester->getDisplay());
        $this->assertEquals(1, $commandTester->getStatusCode()); // Command::FAILURE
    }

    public function testExecuteUserIsActive()
    {
        // Given: a user is active
        $email = 'active@example.com';  // Correct the email to reflect an active user
        $amount = 100;
        $this->userRepositoryMock
            ->expects($this->once())
            ->method('checkIfUserIsActiveByEmail')
            ->with($email)
            ->willReturn(true);

        // Mock the dispatch method to return an Envelope containing the command
        $this->busMock
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(CreateInvoiceCommand::class))
            ->willReturn(new Envelope(new CreateInvoiceCommand($email, $amount)));

        // When: the command is executed
        $commandTester = new CommandTester($this->command);
        $commandTester->execute([
            'email' => $email,
            'amount' => $amount
        ]);

        // Then: the output should indicate that the invoice has been created, and the command should succeed
        $this->assertStringContainsString('Invoice has been created', $commandTester->getDisplay());
        $this->assertEquals(0, $commandTester->getStatusCode()); // Command::SUCCESS
    }
}
