<?php

declare(strict_types=1);

namespace PHPDiscordBot\Commands;

use Discord\Discord;
use Discord\Parts\Channel\Message;

class ImageReactionCommand implements CommandInterface
{
    private array $commands;

    public function __construct()
    {
        $this->commands = json_decode(file_get_contents('./images-reactions.json'), true);
    }

    public function process(Message $message, Discord $discord): void
    {

        foreach ($this->commands as $command => $url) {
            if (str_starts_with($message->content, $command)) {
                $path = __DIR__ . '/../../' . $url ;
                $message->channel->sendFile($path, 'new_filename.png', "{$message->author} mandou...", false);
                break;
            }
        }
    }
}
