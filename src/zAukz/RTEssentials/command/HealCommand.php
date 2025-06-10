<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zAukz\RTEssentials\utils\Message;

class HealCommand extends Command {
    public function __construct() {
        parent::__construct("heal", "Restore your health");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return true;
        }
        $sender->setHealth($sender->getMaxHealth());
        Message::send($sender, "You have been healed.");
        return true;
    }
}
