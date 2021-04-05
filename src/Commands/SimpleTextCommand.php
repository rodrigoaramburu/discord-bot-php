<?php

declare(strict_types=1);

namespace PHPDiscordBot\Commands;

use Discord\Discord;
use Discord\Parts\Channel\Message;

class SimpleTextCommand implements CommandInterface
{
    private array $commands;

    public function __construct()
    {
        $this->commands = json_decode(file_get_contents('./commands-simple-text.json'), true);
    }

    public function process(Message $message, Discord $discord): void
    {

        foreach ($this->commands as $command => $text) {
            if (str_starts_with($message->content, $command)) {
                $message->channel->sendMessage("{$message->author} {$text}");
                break;
            }
        }
    }
}
