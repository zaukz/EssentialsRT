<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zAukz\RTEssentials\home\HomeManager;
use zAukz\RTEssentials\utils\Message;

class DelHomeCommand extends Command {
    private HomeManager $homeManager;

    public function __construct(HomeManager $homeManager) {
        parent::__construct("delhome", "Delete a home");
        $this->homeManager = $homeManager;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return true;
        }
        $name = $args[0] ?? "home";
        if ($this->homeManager->delHome($sender, $name)) {
            Message::send($sender, "Home '$name' deleted.");
        } else {
            Message::send($sender, "Home '$name' does not exist.");
        }
        return true;
    }
}
