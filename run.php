<?php

declare(strict_types=1);

use PHPDiscordBot\Commands\DiceRollCommand;
use PHPDiscordBot\Commands\ImageReactionCommand;
use PHPDiscordBot\Commands\SimpleTextCommand;
use PHPDiscordBot\PHPDiscordBot;
use PHPDiscordBot\Processors\CensorshipProcessor;
use PHPDiscordBot\Processors\DRYProcessor;
use PHPDiscordBot\Processors\HelpProcessor;
use PHPDiscordBot\Processors\WelcomeProcessor;

require "./vendor/autoload.php";

$phpDiscordBot = new PHPDiscordBot();

$phpDiscordBot->addCommands( new SimpleTextCommand() );
$phpDiscordBot->addCommands( new DiceRollCommand() );
$phpDiscordBot->addCommands( new ImageReactionCommand() );

$phpDiscordBot->addProcessor( new HelpProcessor() );
$phpDiscordBot->addProcessor( new CensorshipProcessor() );
$phpDiscordBot->addProcessor( new DRYProcessor() );

$phpDiscordBot->addJoinMemberProcessor( new WelcomeProcessor() );


$phpDiscordBot->run();