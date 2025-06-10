<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zAukz\RTEssentials\utils\Message;

class AfkCommand extends Command {
    public static array $afk = [];

    public function __construct() {
        parent::__construct("afk", "Set yourself as AFK");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return true;
        }
        self::$afk[$sender->getName()] = true;
        Message::send($sender, "You are now AFK.");
        return true;
    }
}
