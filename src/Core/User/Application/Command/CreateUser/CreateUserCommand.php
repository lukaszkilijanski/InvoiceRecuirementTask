<?php
declare(strict_types=1);

/**
 * File: CreateUserCommand.php
 *
 * @author Łukasz Kilijański <kilijanskilukasz@gmail.com>
 */

namespace App\Core\User\Application\Command\CreateUser;

class CreateUserCommand
{
    public function __construct(
        public readonly string $email
    ) {}
}