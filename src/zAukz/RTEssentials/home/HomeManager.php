<?php
namespace zAukz\RTEssentials\home;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use zAukz\RTEssentials\RTEssentials;

class HomeManager {
    private Config $homes;
    private int $maxHomes;

    public function __construct(RTEssentials $plugin) {
        $this->homes = new Config($plugin->getDataFolder() . "homes.yml", Config::YAML);
        $this->maxHomes = $plugin->getConfig()->getNested("homes.max-per-player", 5);
    }

    public function setHome(Player $player, string $name): bool {
        $all = $this->homes->get($player->getName(), []);
        if (count($all) >= $this->maxHomes && !isset($all[$name])) return false;
        $all[$name] = [
            "x" => $player->getLocation()->getX(),
            "y" => $player->getLocation()->getY(),
            "z" => $player->getLocation()->getZ(),
            "world" => $player->getWorld()->getFolderName()
        ];
        $this->homes->set($player->getName(), $all);
        $this->homes->save();
        return true;
    }

    public function getHome(Player $player, string $name): ?array {
        $all = $this->homes->get($player->getName(), []);
        return $all[$name] ?? null;
    }

    public function delHome(Player $player, string $name): bool {
        $all = $this->homes->get($player->getName(), []);
        if (!isset($all[$name])) return false;
        unset($all[$name]);
        $this->homes->set($player->getName(), $all);
        $this->homes->save();
        return true;
    }

    public function listHomes(Player $player): array {
        return array_keys($this->homes->get($player->getName(), []));
    }
}
