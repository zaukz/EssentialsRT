<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zAukz\RTEssentials\utils\Message;

class ReplyCommand extends Command {
    public function __construct() {
        parent::__construct("reply", "Reply to last private message");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return true;
        }
        if (count($args) < 1) {
            Message::send($sender, "Usage: /reply <message>");
            return true;
        }
        $last = MsgCommand::$lastMsg[$sender->getName()] ?? null;
        if (!$last) {
            Message::send($sender, "No one to reply to.");
            return true;
        }
        $target = $sender->getServer()->getPlayerExact($last);
        if (!$target) {
            Message::send($sender, "Player not found.");
            return true;
        }
        $msg = implode(" ", $args);
        Message::send($target, "[From {$sender->getName()}] $msg");
        Message::send($sender, "[To {$target->getName()}] $msg");
        return true;
    }
}
