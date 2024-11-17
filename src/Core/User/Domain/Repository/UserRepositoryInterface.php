<?php
declare(strict_types=1);

namespace App\Core\User\Domain\Repository;

use App\Core\User\Domain\Exception\UserNotFoundException;
use App\Core\User\Domain\Status\UserStatus;
use App\Core\User\Domain\User;

interface UserRepositoryInterface
{
    /**
     * @throws UserNotFoundException
     */
    public function getByEmail(string $email): User;

    public function save(User $user): void;

    public function flush(): void;

    public function checkIfUserIsActiveByEmail(string $email): bool;

    public function getUsersByStatus(UserStatus $status);
}
