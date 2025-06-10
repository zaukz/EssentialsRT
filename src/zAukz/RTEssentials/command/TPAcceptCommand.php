<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zAukz\RTEssentials\tpa\TPAHandler;
use zAukz\RTEssentials\utils\Message;

class TPAcceptCommand extends Command {
    private TPAHandler $tpaHandler;

    public function __construct(TPAHandler $tpaHandler) {
        parent::__construct("tpaccept", "Accept a teleport request");
        $this->tpaHandler = $tpaHandler;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return true;
        }
        $fromName = $this->tpaHandler->accept($sender);
        if ($fromName) {
            $from = $sender->getServer()->getPlayerExact($fromName);
            if ($from) {
                $from->teleport($sender->getLocation());
                Message::send($sender, "Teleport request accepted.");
                Message::send($from, "Your teleport request was accepted.");
            }
        } else {
            Message::send($sender, "No pending teleport requests.");
        }
        return true;
    }
}
