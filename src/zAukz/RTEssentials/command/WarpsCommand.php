<?php
namespace zAukz\RTEssentials\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use zAukz\RTEssentials\warp\WarpManager;
use zAukz\RTEssentials\utils\Message;

class WarpsCommand extends Command {
    private WarpManager $warpManager;

    public function __construct(WarpManager $warpManager) {
        parent::__construct("warps", "List all warps");
        $this->warpManager = $warpManager;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        $warps = $this->warpManager->listWarps();
        if (count($warps) > 0) {
            Message::send($sender, "Warps: " . implode(", ", $warps));
        } else {
            Message::send($sender, "No warps set.");
        }
        return true;
    }
}
