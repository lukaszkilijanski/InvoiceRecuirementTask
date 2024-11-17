<?php
declare(strict_types=1);

/**
 * File: GetInactiveUsersQuery.php
 *
 * @author Łukasz Kilijański <kilijanskilukasz@gmail.com>
 */

namespace App\Core\User\Application\Query\GetInactiveUsers;

use App\Core\User\Domain\Status\UserStatus;

class GetInactiveUsersQuery
{
    public function __construct(
        public readonly UserStatus $status = UserStatus::INACTIVE,
    ) {}
}
