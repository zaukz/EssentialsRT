<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zAukz\RTEssentials\warp\WarpManager;
use zAukz\RTEssentials\utils\Message;

class WarpCommand extends Command {
    private WarpManager $warpManager;

    public function __construct(WarpManager $warpManager) {
        parent::__construct("warp", "Teleport to a warp");
        $this->warpManager = $warpManager;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return true;
        }
        if (empty($args[0])) {
            Message::send($sender, "Usage: /warp <name>");
            return true;
        }
        $warp = $this->warpManager->getWarp($args[0]);
        if ($warp) {
            $world = $sender->getServer()->getWorldManager()->getWorldByName($warp["world"]);
            if ($world) {
                $sender->teleport($world->getSafeSpawn());
                $sender->teleport(new \pocketmine\math\Vector3($warp["x"], $warp["y"], $warp["z"]));
                Message::send($sender, "Teleported to warp '{$args[0]}'.");
            } else {
                Message::send($sender, "World for warp '{$args[0]}' not found.");
            }
        } else {
            Message::send($sender, "Warp '{$args[0]}' does not exist.");
        }
        return true;
    }
}
