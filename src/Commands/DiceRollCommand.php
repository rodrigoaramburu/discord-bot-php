<?php

declare(strict_types=1);

namespace PHPDiscordBot\Commands;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;

class DiceRollCommand implements CommandInterface
{
    public function process(Message $message, Discord $discord): void
    {

        if (str_starts_with($message->content, '!roll')) {
            $expression = str_replace('!roll', '', $message->content);
            preg_match('/(?P<ndice>\d*)d(?P<tdice>\d+)(?P<op>[+-]?)(?P<nadicional>\d*)/', $expression, $output_array);

            if(empty($output_array['ndice']) || empty($output_array['tdice']) ){
                $message->channel->sendMessage("{$message->author} - Expressão de dado inválida");
                return ;
            }

            $rollResult = [];
            $total = 0;
            for ($i = 0; $i < intval($output_array['ndice']); $i++) {
                $num = rand(1,  intval($output_array['tdice']));
                $rollResult[] = "($num)";
                $total += $num;
            }
            $resultStr = join(' ', $rollResult);
            if (!empty($output_array['op'])) {
                if ($output_array['op'] === '+') {
                    $total += intval($output_array['nadicional']);
                    $resultStr .= " + {$output_array['nadicional']} ";
                } else {
                    $total -= intval($output_array['nadicional']);
                    $resultStr .= " - {$output_array['nadicional']} ";
                }
            }

            $embed = new Embed($discord);
            $embed->setTitle('Rolagem de dados')
                ->setType(Embed::TYPE_RICH)
                ->setDescription("O membro {$message->author} rolou dado para ver o que dava!")
                ->addField([
                    'name' => "Expressão de Dado:",
                    'value' => $expression,
                    'inline' => false,
                ])
                ->addField([
                    'name' => 'Resultado',
                    'value' => "{$resultStr} = {$total}",
                    'inline' => false,
                ])->setThumbnail('https://cdn2.iconfinder.com/data/icons/circle-icons-1/64/die-256.png');

            $message->channel->sendMessage("", false, $embed);
        }
    }
}
