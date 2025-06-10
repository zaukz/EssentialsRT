<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zAukz\RTEssentials\home\HomeManager;
use zAukz\RTEssentials\utils\Message;

class HomeCommand extends Command {
    private HomeManager $homeManager;

    public function __construct(HomeManager $homeManager) {
        parent::__construct("home", "Teleport to a home");
        $this->homeManager = $homeManager;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return true;
        }
        $name = $args[0] ?? "home";
        $home = $this->homeManager->getHome($sender, $name);
        if ($home) {
            $world = $sender->getServer()->getWorldManager()->getWorldByName($home["world"]);
            if ($world) {
                $sender->teleport($world->getSafeSpawn());
                $sender->teleport(new \pocketmine\math\Vector3($home["x"], $home["y"], $home["z"]));
                Message::send($sender, "Teleported to home '$name'.");
            } else {
                Message::send($sender, "World for home '$name' not found.");
            }
        } else {
            Message::send($sender, "Home '$name' does not exist.");
        }
        return true;
    }
}
