<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zAukz\RTEssentials\utils\Message;

class MsgCommand extends Command {
    public static array $lastMsg = []; // [sender => recipient]

    public function __construct() {
        parent::__construct("msg", "Send a private message");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return true;
        }
        if (count($args) < 2) {
            Message::send($sender, "Usage: /msg <player> <message>");
            return true;
        }
        $target = $sender->getServer()->getPlayerExact($args[0]);
        if (!$target || $target === $sender) {
            Message::send($sender, "Invalid player.");
            return true;
        }
        $msg = implode(" ", array_slice($args, 1));
        Message::send($target, "[From {$sender->getName()}] $msg");
        Message::send($sender, "[To {$target->getName()}] $msg");
        self::$lastMsg[$sender->getName()] = $target->getName();
        self::$lastMsg[$target->getName()] = $sender->getName();
        return true;
    }
}
