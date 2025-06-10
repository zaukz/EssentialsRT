<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zAukz\RTEssentials\warp\WarpManager;
use zAukz\RTEssentials\utils\Message;

class DelWarpCommand extends Command {
    private WarpManager $warpManager;

    public function __construct(WarpManager $warpManager) {
        parent::__construct("delwarp", "Delete a warp");
        $this->warpManager = $warpManager;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (empty($args[0])) {
            Message::send($sender, "Usage: /delwarp <name>");
            return true;
        }
        if ($this->warpManager->delWarp($args[0])) {
            Message::send($sender, "Warp '{$args[0]}' deleted.");
        } else {
            Message::send($sender, "Warp '{$args[0]}' does not exist.");
        }
        return true;
    }
}
