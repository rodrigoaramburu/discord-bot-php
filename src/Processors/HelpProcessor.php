<?php 

declare(strict_types=1);

namespace PHPDiscordBot\Processors;

use Discord\Discord;
use Discord\Parts\Channel\Message;

class HelpProcessor implements ProcessorMessageInterface
{
    public function process(Message $message, Discord $discord): void
    {
        if( $message->channel->id == $_ENV['HELP_CHANNEL'] ) return ;
        
        $content = $message->content;
        if( str_contains($content,'ajuda') || str_contains($content,'dificuldade')){
            $message->channel->sendMessage("{$message->author} se estiver precisando de alguma ajuda poste no canal apropriado <#{$_ENV['HELP_CHANNEL']}>");
        }
    }
}