<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zAukz\RTEssentials\utils\Message;

class FeedCommand extends Command {
    public function __construct() {
        parent::__construct("feed", "Restore your hunger");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return true;
        }
        $sender->getHungerManager()->setFood($sender->getHungerManager()->getMaxFood());
        Message::send($sender, "You have been fed.");
        return true;
    }
}
