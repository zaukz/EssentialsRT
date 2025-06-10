<?php
namespace zAukz\RTEssentials\warp;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use zAukz\RTEssentials\RTEssentials;

class WarpManager {
    private Config $warps;

    public function __construct(RTEssentials $plugin) {
        $this->warps = new Config($plugin->getDataFolder() . "warps.yml", Config::YAML);
    }

    public function setWarp(string $name, Player $player): void {
        $this->warps->set($name, [
            "x" => $player->getLocation()->getX(),
            "y" => $player->getLocation()->getY(),
            "z" => $player->getLocation()->getZ(),
            "world" => $player->getWorld()->getFolderName()
        ]);
        $this->warps->save();
    }

    public function getWarp(string $name): ?array {
        return $this->warps->get($name, null);
    }

    public function delWarp(string $name): bool {
        if ($this->warps->exists($name)) {
            $this->warps->remove($name);
            $this->warps->save();
            return true;
        }
        return false;
    }

    public function listWarps(): array {
        return $this->warps->getAll(true);
    }
}
