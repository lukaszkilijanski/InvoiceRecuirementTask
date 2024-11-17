<?php
declare(strict_types=1);

/**
 * File: GetInactiveUsersQuery.php
 *
 * @author Łukasz Kilijański <kilijanskilukasz@gmail.com>
 */

namespace App\Core\User\Application\Query\GetInactiveUsers;

use App\Core\User\Application\DTO\UserDTO;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetInactiveUsersHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(GetInactiveUsersQuery $query): array
    {
        $users = $this->userRepository->getUsersByStatus(
            $query->status,
        );
        return array_map(function (User $user) {
            return new UserDTO(
                $user->getId(),
                $user->getEmail(),
                $user->getStatus()
            );
        }, $users);
    }
}
