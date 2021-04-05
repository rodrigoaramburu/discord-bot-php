<?php

declare(strict_types=1);

namespace PHPDiscordBot\Processors;

use Discord\Discord;
use Discord\Parts\Channel\Message;

interface ProcessorMessageInterface
{
    public function process(Message $message, Discord $discord): void;
}