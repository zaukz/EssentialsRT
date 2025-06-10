<?php
namespace zAukz\RTEssentials\tpa;

use pocketmine\player\Player;
use zAukz\RTEssentials\RTEssentials;

class TPAHandler {
    private array $requests = []; // [targetName => [fromName, expireTime]]

    public function __construct(RTEssentials $plugin) {}

    public function request(Player $from, Player $to, int $expire = 60): void {
        $this->requests[$to->getName()] = [$from->getName(), time() + $expire];
    }

    public function getRequest(Player $to): ?array {
        if (!isset($this->requests[$to->getName()])) return null;
        if ($this->requests[$to->getName()][1] < time()) {
            unset($this->requests[$to->getName()]);
            return null;
        }
        return $this->requests[$to->getName()];
    }

    public function accept(Player $to): ?string {
        $req = $this->getRequest($to);
        if ($req) {
            unset($this->requests[$to->getName()]);
            return $req[0];
        }
        return null;
    }

    public function deny(Player $to): ?string {
        $req = $this->getRequest($to);
        if ($req) {
            unset($this->requests[$to->getName()]);
            return $req[0];
        }
        return null;
    }
}
