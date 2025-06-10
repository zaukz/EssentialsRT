<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zAukz\RTEssentials\economy\EconomyManager;
use zAukz\RTEssentials\utils\Message;

class BalanceCommand extends Command {
    private EconomyManager $economyManager;

    public function __construct(EconomyManager $economyManager) {
        parent::__construct("balance", "Check your balance");
        $this->economyManager = $economyManager;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return true;
        }
        $bal = $this->economyManager->getBalance($sender);
        Message::send($sender, "Your balance: $bal");
        return true;
    }
}
