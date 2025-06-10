<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zAukz\RTEssentials\tpa\TPAHandler;
use zAukz\RTEssentials\utils\Message;

class TPDenyCommand extends Command {
    private TPAHandler $tpaHandler;

    public function __construct(TPAHandler $tpaHandler) {
        parent::__construct("tpdeny", "Deny a teleport request");
        $this->tpaHandler = $tpaHandler;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return true;
        }
        $fromName = $this->tpaHandler->deny($sender);
        if ($fromName) {
            $from = $sender->getServer()->getPlayerExact($fromName);
            if ($from) {
                Message::send($from, "Your teleport request was denied.");
            }
            Message::send($sender, "Teleport request denied.");
        } else {
            Message::send($sender, "No pending teleport requests.");
        }
        return true;
    }
}
