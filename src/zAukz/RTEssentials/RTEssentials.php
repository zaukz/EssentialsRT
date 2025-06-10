<?php
namespace zAukz\RTEssentials;

use pocketmine\plugin\PluginBase;
use zAukz\RTEssentials\home\HomeManager;
use zAukz\RTEssentials\warp\WarpManager;
use zAukz\RTEssentials\economy\EconomyManager;
use zAukz\RTEssentials\tpa\TPAHandler;
use zAukz\RTEssentials\command\{
    SetHomeCommand, HomeCommand, DelHomeCommand, HomesCommand,
    BalanceCommand, PayCommand,
    TPACommand, TPAcceptCommand, TPDenyCommand,
    SpawnCommand, SetSpawnCommand,
    WarpCommand, SetWarpCommand, DelWarpCommand, WarpsCommand,
    MsgCommand, ReplyCommand, BackCommand, HealCommand, FeedCommand,
    KitCommand, KitsCommand, RulesCommand, AfkCommand, SeenCommand
};

class RTEssentials extends PluginBase {

    public static RTEssentials $instance;

    public HomeManager $homeManager;
    public WarpManager $warpManager;
    public EconomyManager $economyManager;
    public TPAHandler $tpaHandler;

    public function onEnable(): void {
        self::$instance = $this;
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");

        $this->homeManager = new HomeManager($this);
        $this->warpManager = new WarpManager($this);
        $this->economyManager = new EconomyManager($this);
        $this->tpaHandler = new TPAHandler($this);

        $map = $this->getServer()->getCommandMap();

        // Home commands
        $map->register("sethome", new SetHomeCommand($this->homeManager));
        $map->register("home", new HomeCommand($this->homeManager));
        $map->register("delhome", new DelHomeCommand($this->homeManager));
        $map->register("homes", new HomesCommand($this->homeManager));
        // Economy
        $map->register("balance", new BalanceCommand($this->economyManager));
        $map->register("pay", new PayCommand($this->economyManager));
        // TPA
        $map->register("tpa", new TPACommand($this->tpaHandler));
        $map->register("tpaccept", new TPAcceptCommand($this->tpaHandler));
        $map->register("tpdeny", new TPDenyCommand($this->tpaHandler));
        // Spawn
        $map->register("spawn", new SpawnCommand($this));
        $map->register("setspawn", new SetSpawnCommand($this));
        // Warps
        $map->register("warp", new WarpCommand($this->warpManager));
        $map->register("setwarp", new SetWarpCommand($this->warpManager));
        $map->register("delwarp", new DelWarpCommand($this->warpManager));
        $map->register("warps", new WarpsCommand($this->warpManager));
        // Messaging
        $map->register("msg", new MsgCommand());
        $map->register("reply", new ReplyCommand());
        // Misc
        $map->register("back", new BackCommand());
        $map->register("heal", new HealCommand());
        $map->register("feed", new FeedCommand());
        $map->register("kit", new KitCommand());
        $map->register("kits", new KitsCommand());
        $map->register("rules", new RulesCommand());
        $map->register("afk", new AfkCommand());
        $map->register("seen", new SeenCommand());
    }

    public static function getInstance(): RTEssentials {
        return self::$instance;
    }
}
