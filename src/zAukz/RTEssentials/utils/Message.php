<?php
namespace zAukz\RTEssentials\utils;

use pocketmine\player\Player;
use pocketmine\command\CommandSender;

class Message {
    public const PREFIX = "§4§l[§cRTE§4]§r ";

    public static function send(CommandSender $target, string $message): void {
        $target->sendMessage(self::PREFIX . $message);
    }
}
