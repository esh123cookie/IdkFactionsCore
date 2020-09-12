<?php

namespace esh123unicorn\factioncore\command\warp;

use esh123unicorn\factioncore\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\utils\config;
use pocketmine\level\Level;
use pocketmine\level\LevelExpection;
use pocketmine\level\LevelProvider;
use pocketmine\level\ProviderManager;
use pocketmine\level\Position;

class Make extends PluginCommand{

    private $owner;
    
    private $config;
	
    private $valueX;
    private $valueY;
    private $valueZ;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("make.use");
        $this->setDescription("Create your own warps");
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
	$this->config = new Config($this->getPlugin()->getDataFolder() . "/config.yml", Config::YAML);
	$this->valueX = $sender->getX();
	$this->valueY = $sender->getY();
	$this->valueZ = $sender->getZ();
	$this->level = $sender->getLevel()->getFolderName();
        if ($sender->hasPermission("make.use")) {
            if (!isset($args[0])) {
                $sender->sendMessage("§7(§c!§7) §cUsage §7/§cmake §7{§cspawn§7/§cbosses§7/§cpvp§7}");
                return false;
            }
            if ($args[0]) {
                switch (strtolower($args[0])) {
                    case 'spawn':
			$this->config->set("warp1x", $this->valueX);
			$this->config->set("warp1y", $this->valueY);
			$this->config->set("warp1z", $this->valueZ);
			$this->config->set("warp1level", $this->level);
			$sender->sendMessage("§7(§a!§7) §aYou create spawn in world §c" . $level . $this->valueX . $this->valueY . $this->valueZ);
			$this->config->save();
                        break;
                    case 'bosses':
			$this->config->set("warp2x", $this->valueX);
			$this->config->set("warp2y", $this->valueY);
			$this->config->set("warp2z", $this->valueZ);
			$this->config->set("warp2level", $this->level);
			$sender->sendMessage("§7(§a!§7) §aYou create bosses in world §c" . $level . $this->valueX . $this->valueY . $this->valueZ);
			$this->config->save();
                        break;
                    case 'pvp':
			$this->config->set("warp3x", $this->valueX);
			$this->config->set("warp3y", $this->valueY);
			$this->config->set("warp3z", $this->valueZ);
			$this->config->set("warp3level", $this->level);
			$sender->sendMessage("§7(§a!§7) §aYou create pvp in world §c" . $level . $this->valueX . $this->valueY . $this->valueZ);
			$this->config->save();
                        break;
			}
	    }
        } else {
            $sender->sendMessage("§7(§c!§7) §cYou do not have permission to use this command");
            return false;
        }
        return false;
    }
}
