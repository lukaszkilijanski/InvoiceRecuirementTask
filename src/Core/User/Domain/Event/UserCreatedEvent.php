<?php
declare(strict_types=1);

/**
 * File: UserCreatedEvent.php
 *
 * @author Łukasz Kilijański <kilijanskilukasz@gmail.com>
 */

namespace App\Core\User\Domain\Event;

use App\Common\EventManager\EventsCollectorTrait;

class UserCreatedEvent extends AbstractUserEvent
{
    use EventsCollectorTrait;
}