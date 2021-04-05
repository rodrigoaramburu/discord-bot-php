<?php

declare(strict_types=1);

namespace PHPDiscordBot\Commands;

use Discord\Discord;
use Discord\Parts\Channel\Message;

interface CommandInterface
{
    public function process(Message $message, Discord $discord): void;
}
