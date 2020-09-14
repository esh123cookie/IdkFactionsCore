<?php

namespace esh123unicorn\factioncore\command\extra;

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

class Fly extends PluginCommand{

    private $owner;
    
    private $config;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("fly.use");
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$sender->hasPermission("fly.use")) { 
           $this->openFly($sender);   
        } else {
           $sender->sendMessage("§7(§c!§7) §cYou do not have permission to use this command");
           }
    }
    
    public function openFly(Player $player) { 
	   $config = new Config($this->getPlugin()->getDataFolder() . "/config.yml", Config::YAML);
       if($player->isFlying()) { 
          $player->setAllowFlight(false);
          $player->sendMessage($config->get("fly-disable"));
       }else{
          $player->setAllowFlight(true);
          $player->sendMessage($config->get("fly-enabled"));
       }
    }
}
           
        
        
        
        
        
