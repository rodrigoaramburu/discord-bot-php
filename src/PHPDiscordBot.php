<?php

declare(strict_types=1);

namespace PHPDiscordBot;

use DateTime;
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Parts\User\Member;
use Discord\WebSockets\Event;
use Dotenv\Dotenv;
use PHPDiscordBot\Commands\CommandInterface;
use PHPDiscordBot\Processors\ProcessorMemberJoinInterface;
use PHPDiscordBot\Processors\ProcessorMessageInterface;

class PHPDiscordBot
{

    private Discord $discord;

    private array $commands;
    private array $processors;
    private array $joinMemberprocessors;

    public function __construct()
    {
        $dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../');
        $dotenv->load();
        $this->discord = new Discord([
            'token' => $_ENV['DISCORD_TOKEN'],
        ]);
    }

    public function addCommands(CommandInterface $command): void
    {
        $this->commands[] = $command;
    }
    public function addProcessor(ProcessorMessageInterface $processor): void
    {
        $this->processors[] = $processor;
    }

    public function addJoinMemberProcessor(ProcessorMemberJoinInterface $joinMemberprocessors): void
    {
        $this->joinMemberprocessors[] = $joinMemberprocessors;
    }

    public function run(): void
    {
        $this->discord->on('ready', function (Discord $discord) {
            echo $discord->username . ' está online ' . PHP_EOL;

            $this->initMessageEvent();

            $this->initJoinEvent();

            $this->initScheduleEvent();
        });


        $this->discord->run();
    }

    private function initMessageEvent(): void
    {
        $this->discord->on(Event::MESSAGE_CREATE, function (Message $message, Discord $discord) {
            if ($message->author->id === $discord->id) return;

            if (str_starts_with($message->content, '!')) {
                foreach ($this->commands as $command) {
                    $command->process($message, $discord);
                }
            }

            foreach ($this->processors as $processor) {
                $processor->process($message, $discord);
            }
        });
    }

    private function initJoinEvent(): void
    {
        $this->discord->on(Event::GUILD_MEMBER_ADD, function (Member $member, Discord $discord) {
            foreach ($this->joinMemberprocessors as $joinMemberprocessor) {
                $joinMemberprocessor->process($member, $discord);
            }
        });
    }

    private function initScheduleEvent(): void
    {
        $discord = $this->discord;
        $schedules = json_decode(file_get_contents('./scheduled-messages.json'), true)['schedules'];
        $now = new DateTime();

        foreach ($schedules as $schedule) {
            $date = new DateTime($schedule['date']);
            $diff = $date->getTimestamp() - $now->getTimestamp();
            if($diff <= 0) continue;
            $this->discord->getLoop()->addTimer($diff, function () use ($discord, $schedule) {
                $discord->getChannel($schedule['channel'])->sendMessage($schedule['message']);
            });
        }
    }
}
