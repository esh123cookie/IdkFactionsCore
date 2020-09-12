<?php

namespace esh123unicorn\factioncore\event;

//pocketmine
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\math\Vector3;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\inventory\ShapedRecipe;
use pocketmine\utils\Utils;
use pocketmine\utils\config;

//level
use pocketmine\level\Level;
use pocketmine\level\LevelExpection;
use pocketmine\level\LevelProvider;
use pocketmine\level\ProviderManager;
use pocketmine\level\Position;
use pocketmine\event\Listener;

//function 
use function time;
use function count;
use function floor;
use function microtime;
use function number_format;
use function round;
use function strtotime; //string to time
use function strtolower; //string lowers all letters
use function strtoupper; //string upper letters all
use function ucfirst; //first letter of string capital

use esh123unicorn\factioncore\Main;

class DataBackUps implements Listener{

    private $plugin;
	
    public $config;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }
	
    public function getPlugin(){
	return $this->plugin;
    }
	
    public function storeConfig(): void { 
              if(!file_exists($this->plugin->getDataFolder() . "/config.yml")) {
		 $config = new Config($this->plugin->getDataFolder() . "/config.yml", Config::YAML);
            	 $array = [
      	    		$config->setNested("faction-text-prefix", "§7["),
      	    		$config->setNested("faction-text-suffix", "§7]"),
      	    		$config->setNested("gen-id", "1,0"),
      	    		$config->setNested("gen-name", "WALL-GENERATOR"),
      	    		$config->setNested("max-distance", "120")
      	    	 ];
      	    	 $config->save();
	      }
    }
	
    public function storeKitsUI(): void { 
              if(!file_exists($this->plugin->kitFolder() . "/kits.yml")) {
		 $kit = new Config($this->plugin->kitFolder() . "/kits.yml", Config::YAML);
            	 $userinterface = [
      	    		$kit->setNested("title", "Kits"),
      	    		$kit->setNested("content", "pick a kit:"),
      	    		$kit->setNested("button1", "kit1"),
      	    		$kit->setNested("button2", "kit2"),
      	    		$kit->setNested("button3", "kit3"),
      	    		$kit->setNested("button4", "kit4"),
      	    		$kit->setNested("button5", "kit5"),
      	    		$kit->setNested("exit-button", "Exit")
      	    	 ];
      	    	 $kit->save();
	      }
    }
	
    public function storeKitsItems(): void {  
              if(!file_exists($this->plugin->kitFolder() . "/config.yml")) {
		 $config = new Config($this->plugin->kitFolder() . "/config.yml", Config::YAML);
            	 $c = [
      	    		$c->setNested("unlocked", "UNLOCKED"),
      	    		$c->setNested("locked", "LOCKED"),
      	    		$c->setNested("time", "TIME: ")
		 ];
	      }

              if(!file_exists($this->plugin->kitFolder() . "/kits1.yml")) {
		 $kit = new Config($this->plugin->kitFolder() . "/kit1.yml", Config::YAML);
            	 $userinterface = [
      	    		$kit->setNested("cooldown", 60),
      	    		$kit->setNested("perm", "kit1.use"), 
      	    		$kit->setNested("helmet", "310,0"),
      	    		$kit->setNested("chesplate", "311,0"),
      	    		$kit->setNested("leggings", "312,0"),
      	    		$kit->setNested("boots", "313,0"),
      	    		$kit->setNested("sword", "376,0"),
      	    		$kit->setNested("pickaxe", "278,0"),
      	    		$kit->setNested("hoe", "293,0"),
      	    		$kit->setNested("Armorenchant1", 1),
      	    		$kit->setNested("Armorlevel1", 1),
      	    		$kit->setNested("Armorenchant2", 2),
      	    		$kit->setNested("Armorlevel2", 1),
      	    		$kit->setNested("Swordenchant1", 1),
      	    		$kit->setNested("Swordlevel1", 1),
      	    		$kit->setNested("Swordenchant2", 2),
      	    		$kit->setNested("Swordlevel2", 1)
      	    	 ];
      	    	 $kit->save();
	      }
	    
              if(!file_exists($this->plugin->kitFolder() . "/kits2.yml")) {
		 $kit = new Config($this->plugin->kitFolder() . "/kit2.yml", Config::YAML);
            	 $userinterface = [
      	    		$kit->setNested("cooldown", 60),
      	    		$kit->setNested("perm", "kit1.use"), 
      	    		$kit->setNested("helmet", "310,0"),
      	    		$kit->setNested("chesplate", "311,0"),
      	    		$kit->setNested("leggings", "312,0"),
      	    		$kit->setNested("boots", "313,0"),
      	    		$kit->setNested("sword", "376,0"),
      	    		$kit->setNested("pickaxe", "278,0"),
      	    		$kit->setNested("hoe", "293,0"),
      	    		$kit->setNested("Armorenchant1", 1),
      	    		$kit->setNested("Armorlevel1", 1),
      	    		$kit->setNested("Armorenchant2", 2),
      	    		$kit->setNested("Armorlevel2", 1),
      	    		$kit->setNested("Swordenchant1", 1),
      	    		$kit->setNested("Swordlevel1", 1),
      	    		$kit->setNested("Swordenchant2", 2),
      	    		$kit->setNested("Swordlevel2", 1)
      	    	 ];
      	    	 $kit->save();
	      }
	    
              if(!file_exists($this->plugin->kitFolder() . "/kits3.yml")) {
		 $kit = new Config($this->plugin->kitFolder() . "/kit3.yml", Config::YAML);
            	 $userinterface = [
      	    		$kit->setNested("cooldown", 60),
      	    		$kit->setNested("perm", "kit1.use"), 
      	    		$kit->setNested("helmet", "310,0"),
      	    		$kit->setNested("chesplate", "311,0"),
      	    		$kit->setNested("leggings", "312,0"),
      	    		$kit->setNested("boots", "313,0"),
      	    		$kit->setNested("sword", "376,0"),
      	    		$kit->setNested("pickaxe", "278,0"),
      	    		$kit->setNested("hoe", "293,0"),
      	    		$kit->setNested("Armorenchant1", 1),
      	    		$kit->setNested("Armorlevel1", 1),
      	    		$kit->setNested("Armorenchant2", 2),
      	    		$kit->setNested("Armorlevel2", 1),
      	    		$kit->setNested("Swordenchant1", 1),
      	    		$kit->setNested("Swordlevel1", 1),
      	    		$kit->setNested("Swordenchant2", 2),
      	    		$kit->setNested("Swordlevel2", 1)
      	    	 ];
      	    	 $kit->save();
	      }
	    
              if(!file_exists($this->plugin->kitFolder() . "/kits4.yml")) {
		 $kit = new Config($this->plugin->kitFolder() . "/kit4.yml", Config::YAML);
            	 $userinterface = [
      	    		$kit->setNested("cooldown", 60),
      	    		$kit->setNested("perm", "kit1.use"), 
      	    		$kit->setNested("helmet", "310,0"),
      	    		$kit->setNested("chesplate", "311,0"),
      	    		$kit->setNested("leggings", "312,0"),
      	    		$kit->setNested("boots", "313,0"),
      	    		$kit->setNested("sword", "376,0"),
      	    		$kit->setNested("pickaxe", "278,0"),
      	    		$kit->setNested("hoe", "293,0"),
      	    		$kit->setNested("Armorenchant1", 1),
      	    		$kit->setNested("Armorlevel1", 1),
      	    		$kit->setNested("Armorenchant2", 2),
      	    		$kit->setNested("Armorlevel2", 1),
      	    		$kit->setNested("Swordenchant1", 1),
      	    		$kit->setNested("Swordlevel1", 1),
      	    		$kit->setNested("Swordenchant2", 2),
      	    		$kit->setNested("Swordlevel2", 1)
      	    	 ];
      	    	 $kit->save();
	      }
	    
              if(!file_exists($this->plugin->kitFolder() . "/kits5.yml")) {
		 $kit = new Config($this->plugin->kitFolder() . "/kit5.yml", Config::YAML);
            	 $userinterface = [
      	    		$kit->setNested("cooldown", 60),
      	    		$kit->setNested("perm", "kit1.use"), 
      	    		$kit->setNested("helmet", "310,0"),
      	    		$kit->setNested("chesplate", "311,0"),
      	    		$kit->setNested("leggings", "312,0"),
      	    		$kit->setNested("boots", "313,0"),
      	    		$kit->setNested("sword", "376,0"),
      	    		$kit->setNested("pickaxe", "278,0"),
      	    		$kit->setNested("hoe", "293,0"),
      	    		$kit->setNested("Armorenchant1", 1),
      	    		$kit->setNested("Armorlevel1", 1),
      	    		$kit->setNested("Armorenchant2", 2),
      	    		$kit->setNested("Armorlevel2", 1),
      	    		$kit->setNested("Swordenchant1", 1),
      	    		$kit->setNested("Swordlevel1", 1),
      	    		$kit->setNested("Swordenchant2", 2),
      	    		$kit->setNested("Swordlevel2", 1)
      	    	 ];
      	    	 $kit->save();
	      }
    }
	
    public function storeWarpsUI(): void { 
              if(!file_exists($this->plugin->getDataFolder() . "/warps.yml")) {
		 $warp = new Config($this->plugin->getDataFolder() . "/warps.yml", Config::YAML);
            	 $userinterface = [
      	    		$warp->setNested("title", "Warps"),
      	    		$warp->setNested("content", "click to warp:"),
      	    		$warp->setNested("button1", "warp1"),
      	    		$warp->setNested("button2", "warp2"),
      	    		$warp->setNested("button2", "warp3"),
      	    		$warp->setNested("exit-button", "Exit")
      	    	 ];
      	    	 $warp->save();
	      }
    }
	
    public function storeCoordinates(): void { 
              if(!file_exists($this->plugin->getDataFolder() . "/cords.yml")) {
		 $cord = new Config($this->plugin->getDataFolder() . "/cords.yml", Config::YAML);
            	 $setup = [
      	    		$cord->setNested("warp1level", "null"),
      	    		$cord->setNested("warp1x", null),
      	    		$cord->setNested("warp1y", null),
      	    		$cord->setNested("warp1z", null),
			 
      	    		$cord->setNested("warp2level", "null"),
      	    		$cord->setNested("warp2x", null),
      	    		$cord->setNested("warp2y", null),
      	    		$cord->setNested("warp2z", null),
			 
      	    		$cord->setNested("warp3level", "null"),
      	    		$cord->setNested("warp3x", null),
      	    		$cord->setNested("warp3y", null),
      	    		$cord->setNested("warp3z", null)
      	    	 ];
      	    	 $cord->save(); 
	      }
    }
}
