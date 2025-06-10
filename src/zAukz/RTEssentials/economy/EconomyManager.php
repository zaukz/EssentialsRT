<?php
namespace zAukz\RTEssentials\economy;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use zAukz\RTEssentials\RTEssentials;

class EconomyManager {
    private Config $balances;
    private int $startBalance;

    public function __construct(RTEssentials $plugin) {
        $this->balances = new Config($plugin->getDataFolder() . "balances.yml", Config::YAML);
        $this->startBalance = $plugin->getConfig()->getNested("economy.start-balance", 1000);
    }

    public function getBalance(Player $player): int {
        $bal = $this->balances->get($player->getName(), $this->startBalance);
        if ($bal === null) {
            $this->balances->set($player->getName(), $this->startBalance);
            $this->balances->save();
            return $this->startBalance;
        }
        return $bal;
    }

    public function setBalance(Player $player, int $amount): void {
        $this->balances->set($player->getName(), $amount);
        $this->balances->save();
    }

    public function addBalance(Player $player, int $amount): void {
        $this->setBalance($player, $this->getBalance($player) + $amount);
    }

    public function reduceBalance(Player $player, int $amount): bool {
        $bal = $this->getBalance($player);
        if ($bal < $amount) return false;
        $this->setBalance($player, $bal - $amount);
        return true;
    }
}
