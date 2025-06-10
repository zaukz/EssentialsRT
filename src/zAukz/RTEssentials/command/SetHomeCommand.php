<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zAukz\RTEssentials\home\HomeManager;
use zAukz\RTEssentials\utils\Message;

class SetHomeCommand extends Command {
    private HomeManager $homeManager;

    public function __construct(HomeManager $homeManager) {
        parent::__construct("sethome", "Set a home location");
        $this->homeManager = $homeManager;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return true;
        }
        $name = $args[0] ?? "home";
        if ($this->homeManager->setHome($sender, $name)) {
            Message::send($sender, "Home '$name' set!");
        } else {
            Message::send($sender, "Failed to set home. (Max homes reached?)");
        }
        return true;
    }
}
