<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zAukz\RTEssentials\utils\Message;

class BackCommand extends Command {
    public static array $lastLocation = []; // [playerName => Location]

    public function __construct() {
        parent::__construct("back", "Return to your last location");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return true;
        }
        $loc = self::$lastLocation[$sender->getName()] ?? null;
        if ($loc) {
            $sender->teleport($loc);
            Message::send($sender, "Teleported to your last location.");
        } else {
            Message::send($sender, "No previous location found.");
        }
        return true;
    }
}
