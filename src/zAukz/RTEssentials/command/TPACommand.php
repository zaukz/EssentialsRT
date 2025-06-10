<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zAukz\RTEssentials\tpa\TPAHandler;
use zAukz\RTEssentials\utils\Message;

class TPACommand extends Command {
    private TPAHandler $tpaHandler;

    public function __construct(TPAHandler $tpaHandler) {
        parent::__construct("tpa", "Request to teleport to another player");
        $this->tpaHandler = $tpaHandler;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return true;
        }
        if (empty($args[0])) {
            Message::send($sender, "Usage: /tpa <player>");
            return true;
        }
        $target = $sender->getServer()->getPlayerExact($args[0]);
        if (!$target || $target === $sender) {
            Message::send($sender, "Invalid player.");
            return true;
        }
        $this->tpaHandler->request($sender, $target);
        Message::send($sender, "Teleport request sent to {$target->getName()}.");
        Message::send($target, "{$sender->getName()} has requested to teleport to you. Use /tpaccept or /tpdeny.");
        return true;
    }
}
