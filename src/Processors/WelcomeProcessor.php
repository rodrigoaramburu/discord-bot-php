<?php

declare(strict_types=1);

namespace PHPDiscordBot\Processors;

use Discord\Discord;
use Discord\Parts\User\Member;
use PHPDiscordBot\Processors\ProcessorMemberJoinInterface;

class WelcomeProcessor implements ProcessorMemberJoinInterface
{
    public function process(Member $member, Discord $discord): void
    {
        $channel = $discord->getChannel($_ENV['WELCOME_CHANNEL']);
        $welcomeText = file_get_contents('./welcome-message.txt');
        $welcomeText = str_replace('[MEMBER]', $member->__toString(), $welcomeText);

        $channel->sendMessage($welcomeText);
    }
}
