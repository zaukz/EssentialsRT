<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zAukz\RTEssentials\warp\WarpManager;
use zAukz\RTEssentials\utils\Message;

class SetWarpCommand extends Command {
    private WarpManager $warpManager;

    public function __construct(WarpManager $warpManager) {
        parent::__construct("setwarp", "Set a warp");
        $this->warpManager = $warpManager;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return true;
        }
        if (empty($args[0])) {
            Message::send($sender, "Usage: /setwarp <name>");
            return true;
        }
        $this->warpManager->setWarp($args[0], $sender);
        Message::send($sender, "Warp '{$args[0]}' set!");
        return true;
    }
}
