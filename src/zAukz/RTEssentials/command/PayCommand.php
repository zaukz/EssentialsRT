<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zAukz\RTEssentials\economy\EconomyManager;
use zAukz\RTEssentials\utils\Message;

class PayCommand extends Command {
    private EconomyManager $economyManager;

    public function __construct(EconomyManager $economyManager) {
        parent::__construct("pay", "Pay another player");
        $this->economyManager = $economyManager;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return true;
        }
        if (count($args) < 2) {
            Message::send($sender, "Usage: /pay <player> <amount>");
            return true;
        }
        $target = $sender->getServer()->getPlayerExact($args[0]);
        $amount = intval($args[1]);
        if (!$target || $target === $sender) {
            Message::send($sender, "Invalid player.");
            return true;
        }
        if ($amount <= 0) {
            Message::send($sender, "Invalid amount.");
            return true;
        }
        if ($this->economyManager->reduceBalance($sender, $amount)) {
            $this->economyManager->addBalance($target, $amount);
            Message::send($sender, "Paid $amount to {$target->getName()}.");
            Message::send($target, "You received $amount from {$sender->getName()}.");
        } else {
            Message::send($sender, "Insufficient funds.");
        }
        return true;
    }
}
