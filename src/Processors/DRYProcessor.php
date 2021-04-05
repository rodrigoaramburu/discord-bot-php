<?php

declare(strict_types=1);

namespace PHPDiscordBot\Processors;

use Discord\Discord;
use Discord\Helpers\Collection;
use Discord\Parts\Channel\Message;

/**
 * Filtro para membro não mandar mensagens repetidas 
 * */ 

class DRYProcessor implements ProcessorMessageInterface
{
    public function process(Message $message, Discord $discord): void 
    {
        $message->channel->getMessageHistory([
            'limit' => 10,
        ])->done(function (Collection $messages) use ($message) {
            foreach ($messages as $m) {
                if($m->author->id !== $message->author->id) continue;

                if( levenshtein($message->content, $m->content) < 3 && $message->id != $m->id ){
                    $message->channel->sendMessage("{$message->autor} não envie mensagens repetidas!");
                    $message->delete();
                }

            }
        });
    }
}