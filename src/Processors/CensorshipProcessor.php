<?php

declare(strict_types=1);

namespace PHPDiscordBot\Processors;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use PHPDiscordBot\Processors\ProcessorMessageInterface;

class CensorshipProcessor implements ProcessorMessageInterface
{
    private array $words;

    public function __construct()
    {
        $this->words = json_decode(file_get_contents('./censorship-words.json'), true)['words'];
    }
    public function process(Message $message, Discord $discord): void
    {
        foreach ($this->words as $word) {
            if( str_contains($message->content, $word) ){
                $message->channel->sendMessage("{$message->author} Mensagem deletada, este é um chat de familia, olha a boca!");
                $message->delete();
            }
        }
    }
}
