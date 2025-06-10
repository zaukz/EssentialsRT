<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use zAukz\RTEssentials\utils\Message;

class SeenCommand extends Command {
    public function __construct() {
        parent::__construct("seen", "Check when a player was last online");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (empty($args[0])) {
            Message::send($sender, "Usage: /seen <player>");
            return true;
        }
        // Placeholder: Would require tracking player logins/logouts
        Message::send($sender, "Seen command not yet implemented.");
        return true;
    }
}
