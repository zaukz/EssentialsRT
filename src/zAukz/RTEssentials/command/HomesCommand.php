<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zAukz\RTEssentials\home\HomeManager;
use zAukz\RTEssentials\utils\Message;

class HomesCommand extends Command {
    private HomeManager $homeManager;

    public function __construct(HomeManager $homeManager) {
        parent::__construct("homes", "List your homes");
        $this->homeManager = $homeManager;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return true;
        }
        $homes = $this->homeManager->listHomes($sender);
        if (count($homes) > 0) {
            Message::send($sender, "Your homes: " . implode(", ", $homes));
        } else {
            Message::send($sender, "You have no homes set.");
        }
        return true;
    }
}
