<?php 

declare(strict_types=1);

namespace PHPDiscordBot\Processors;

use Discord\Discord;
use Discord\Parts\User\Member;

interface ProcessorMemberJoinInterface
{
    public function process(Member $member, Discord $discord);
}