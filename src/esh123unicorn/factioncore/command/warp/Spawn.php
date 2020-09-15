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

//form ui
use jojoe77777\FormAPI;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;

class Spawn extends PluginCommand{

    private $owner;
    
    private $config;
    private $cords;
    
    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("spawn.use");
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
            if($sender->hasPermission("spawn.use")) {
               $this->openSpawn($sender);   
            } else {
               $sender->sendMessage("§7(§c!§7) §cYou do not have permission to use this command");
            }
    }
               
                
    public function openSpawn(Player $sender)
    {
        	$this->config = new Config($this->getPlugin()->getDataFolder() . "/warps.yml", Config::YAML);
        	$this->cords = new Config($this->getPlugin()->getDataFolder() . "/cords.yml", Config::YAML);
	        $x = $this->cords->get("warp1x");
	        $y = $this->cords->get("warp1y");
	        $z = $this->cords->get("warp1z");
	        $world1 = $this->cords->get("warp1level");
	    
	        if($world1 == null) {
	           $sender->sendMessage("§7(§c!§7) §cSpawn has not been set yet");
	        }else{
     	       	   $world = $this->getPlugin()->getServer()->getLevelByName($world1);
     	       	   $sender->teleport($world->getSafeSpawn());
               	   $sender->teleport(new Vector3($x, $y, $z, 0, 0));
               	   $sender->sendMessage("§7(§a!§7) §aYou are being warped to spawn..."); 
		}
    }
}
