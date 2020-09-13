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

class StoreData implements Listener{

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
      	    		$config->setNested("vote-message", "you voted"),
      	    		$config->setNested("vote-broadcast", " has voted for cosmicpe"),
      	    		$config->setNested("faction-text-prefix", "§7["),
      	    		$config->setNested("faction-text-suffix", "§7]"),
      	    		$config->setNested("level-text-prefix", "§7["),
      	    		$config->setNested("level-text-suffix", "§7]"),
      	    		$config->setNested("gen-id", "1,0"),
      	    		$config->setNested("gen-name", "WALL-GENERATOR"),
      	    		$config->setNested("max-distance", "120")
      	    	 ];
      	    	 $config->save();
	      }
    }
	
    public function storeKitsUI(): void { 
              if(!file_exists($this->plugin->kitFolder . "/kits.yml")) {
		 $kit = new Config($this->plugin->kitFolder . "/kits.yml", Config::YAML);
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
              if(!file_exists($this->plugin->kitFolder . "/config.yml")) {
		 $config = new Config($this->plugin->kitFolder . "/config.yml", Config::YAML);
            	 $c = [
      	    		$config->setNested("unlocked", "UNLOCKED"),
      	    		$config->setNested("locked", "LOCKED"),
      	    		$config->setNested("time", "TIME: ")
		 ];
	      }

              if(!file_exists($this->plugin->kitFolder . "/kits1.yml")) {
		 $kit = new Config($this->plugin->kitFolder . "/kit1.yml", Config::YAML);
            	 $userinterface = [
      	    		$kit->setNested("claim-message", "claimed kit1"),
      	    		$kit->setNested("cooldown", 60),
      	    		$kit->setNested("perm", "kit1.use"), 
      	    		$kit->setNested("helmet", "310,0"),
      	    		$kit->setNested("chesplate", "311,0"),
      	    		$kit->setNested("leggings", "312,0"),
      	    		$kit->setNested("boots", "313,0"),
      	    		$kit->setNested("sword", "376,0"),
      	    		$kit->setNested("pickaxe", "278,0"),
     	    		$kit->setNested("axe", "293,0"),
      	    		$kit->setNested("hoe", "293,0"),
      	    		$kit->setNested("Armorenchant1", 1),
      	    		$kit->setNested("Armorlevel1", 1),
      	    		$kit->setNested("Armorenchant2", 2),
      	    		$kit->setNested("Armorlevel2", 1),
      	    		$kit->setNested("Toolenchant1", 1),
      	    		$kit->setNested("Toollevel1", 1),
      	    		$kit->setNested("Toolenchant2", 2),
      	    		$kit->setNested("Toollevel2", 1),
      	    		$kit->setNested("Swordenchant1", 1),
      	    		$kit->setNested("Swordlevel1", 1),
      	    		$kit->setNested("Swordenchant2", 2),
      	    		$kit->setNested("Swordlevel2", 1)
      	    	 ];
      	    	 $kit->save();
	      }
	    
              if(!file_exists($this->plugin->kitFolder . "/kits2.yml")) {
		 $kit = new Config($this->plugin->kitFolder . "/kit2.yml", Config::YAML);
            	 $userinterface = [
      	    		$kit->setNested("claim-message", "claimed kit1"),
      	    		$kit->setNested("cooldown", 60),
      	    		$kit->setNested("perm", "kit1.use"), 
      	    		$kit->setNested("helmet", "310,0"),
      	    		$kit->setNested("chesplate", "311,0"),
      	    		$kit->setNested("leggings", "312,0"),
      	    		$kit->setNested("boots", "313,0"),
      	    		$kit->setNested("sword", "376,0"),
      	    		$kit->setNested("pickaxe", "278,0"),
     	    		$kit->setNested("axe", "293,0"),
      	    		$kit->setNested("hoe", "293,0"),
      	    		$kit->setNested("Armorenchant1", 1),
      	    		$kit->setNested("Armorlevel1", 1),
      	    		$kit->setNested("Armorenchant2", 2),
      	    		$kit->setNested("Armorlevel2", 1),
      	    		$kit->setNested("Toolenchant1", 1),
      	    		$kit->setNested("Toollevel1", 1),
      	    		$kit->setNested("Toolenchant2", 2),
      	    		$kit->setNested("Toollevel2", 1),
      	    		$kit->setNested("Swordenchant1", 1),
      	    		$kit->setNested("Swordlevel1", 1),
      	    		$kit->setNested("Swordenchant2", 2),
      	    		$kit->setNested("Swordlevel2", 1)
      	    	 ];
      	    	 $kit->save();
	      }
	    
              if(!file_exists($this->plugin->kitFolder . "/kits3.yml")) {
		 $kit = new Config($this->plugin->kitFolder . "/kit3.yml", Config::YAML);
            	 $userinterface = [
      	    		$kit->setNested("claim-message", "claimed kit1"),
      	    		$kit->setNested("cooldown", 60),
      	    		$kit->setNested("perm", "kit1.use"), 
      	    		$kit->setNested("helmet", "310,0"),
      	    		$kit->setNested("chesplate", "311,0"),
      	    		$kit->setNested("leggings", "312,0"),
      	    		$kit->setNested("boots", "313,0"),
      	    		$kit->setNested("sword", "376,0"),
      	    		$kit->setNested("pickaxe", "278,0"),
     	    		$kit->setNested("axe", "293,0"),
      	    		$kit->setNested("hoe", "293,0"),
      	    		$kit->setNested("Armorenchant1", 1),
      	    		$kit->setNested("Armorlevel1", 1),
      	    		$kit->setNested("Armorenchant2", 2),
      	    		$kit->setNested("Armorlevel2", 1),
      	    		$kit->setNested("Toolenchant1", 1),
      	    		$kit->setNested("Toollevel1", 1),
      	    		$kit->setNested("Toolenchant2", 2),
      	    		$kit->setNested("Toollevel2", 1),
      	    		$kit->setNested("Swordenchant1", 1),
      	    		$kit->setNested("Swordlevel1", 1),
      	    		$kit->setNested("Swordenchant2", 2),
      	    		$kit->setNested("Swordlevel2", 1)
      	    	 ];
      	    	 $kit->save();
	      }
	    
              if(!file_exists($this->plugin->kitFolder . "/kits4.yml")) {
		 $kit = new Config($this->plugin->kitFolder . "/kit4.yml", Config::YAML);
            	 $userinterface = [
      	    		$kit->setNested("claim-message", "claimed kit1"),
      	    		$kit->setNested("cooldown", 60),
      	    		$kit->setNested("perm", "kit1.use"), 
      	    		$kit->setNested("helmet", "310,0"),
      	    		$kit->setNested("chesplate", "311,0"),
      	    		$kit->setNested("leggings", "312,0"),
      	    		$kit->setNested("boots", "313,0"),
      	    		$kit->setNested("sword", "376,0"),
      	    		$kit->setNested("pickaxe", "278,0"),
     	    		$kit->setNested("axe", "293,0"),
      	    		$kit->setNested("hoe", "293,0"),
      	    		$kit->setNested("Armorenchant1", 1),
      	    		$kit->setNested("Armorlevel1", 1),
      	    		$kit->setNested("Armorenchant2", 2),
      	    		$kit->setNested("Armorlevel2", 1),
      	    		$kit->setNested("Toolenchant1", 1),
      	    		$kit->setNested("Toollevel1", 1),
      	    		$kit->setNested("Toolenchant2", 2),
      	    		$kit->setNested("Toollevel2", 1),
      	    		$kit->setNested("Swordenchant1", 1),
      	    		$kit->setNested("Swordlevel1", 1),
      	    		$kit->setNested("Swordenchant2", 2),
      	    		$kit->setNested("Swordlevel2", 1)
      	    	 ];
      	    	 $kit->save();
	      }
	    
              if(!file_exists($this->plugin->kitFolder . "/kits5.yml")) {
		 $kit = new Config($this->plugin->kitFolder . "/kit5.yml", Config::YAML);
            	 $userinterface = [
      	    		$kit->setNested("claim-message", "claimed kit1"),
      	    		$kit->setNested("cooldown", 60),
      	    		$kit->setNested("perm", "kit1.use"), 
      	    		$kit->setNested("helmet", "310,0"),
      	    		$kit->setNested("chesplate", "311,0"),
      	    		$kit->setNested("leggings", "312,0"),
      	    		$kit->setNested("boots", "313,0"),
      	    		$kit->setNested("sword", "376,0"),
      	    		$kit->setNested("pickaxe", "278,0"),
     	    		$kit->setNested("axe", "293,0"),
      	    		$kit->setNested("hoe", "293,0"),
      	    		$kit->setNested("Armorenchant1", 1),
      	    		$kit->setNested("Armorlevel1", 1),
      	    		$kit->setNested("Armorenchant2", 2),
      	    		$kit->setNested("Armorlevel2", 1),
      	    		$kit->setNested("Toolenchant1", 1),
      	    		$kit->setNested("Toollevel1", 1),
      	    		$kit->setNested("Toolenchant2", 2),
      	    		$kit->setNested("Toollevel2", 1),
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
	
    public function storeLevelUpInfo(): void { 
              if(!file_exists($this->plugin->getDataFolder() . "/levelup.yml")) {
		 $config = new Config($this->plugin->getDataFolder() . "/levelup.yml", Config::YAML);
            	 $level = [
      	    		$config->setNested("levels", 10),
      	    		$config->setNested("economy-multiplier", 50),
      	    		$config->setNested("levelup-message", "You leveled up to level "),
      	    		$config->setNested("not-enough-money-message", "Not enough money to level up"),
      	    		$config->setNested("max-level-message", "Your level is already max")
      	    	 ];
      	    	 $config->save(); 
	      }
    }
	
    public function storeShopUI(): void { 
              if(!file_exists($this->plugin->getDataFolder() . "/shop.yml")) {
		 $config = new Config($this->plugin->getDataFolder() . "/shop.yml", Config::YAML);
            	 $shop = [
      	    		$config->setNested("title", "Shop"),
      	    		$config->setNested("content", "Shop"),
      	    		$config->setNested("wall-gen-button", "Wall Gen"),
      	    		$config->setNested("building-button", "Building"),
      	    		$config->setNested("misk-button", "Misk")
			//addmore soon
      	    	 ];
      	    	 $config->save(); 
	      }
    }
	
    public function storeShopPrices(): void { 
              if(!file_exists($this->plugin->getDataFolder() . "/prices.yml")) {
		 $config = new Config($this->plugin->getDataFolder() . "/prices.yml", Config::YAML);
            	 $shop = [
      	    		$config->setNested("logs", 5),
      	    		$config->setNested("wood", 2),
      	    		$config->setNested("stone", 3),
      	    		$config->setNested("cobble", 2),
      	    		$config->setNested("quartz", 15),
      	    		$config->setNested("obsidian", 1000),
      	    		$config->setNested("ice", 10),
      	    		$config->setNested("diorite", 10),
      	    		$config->setNested("granite", 20),
      	    		$config->setNested("andesite", 30),
      	    		$config->setNested("polished-diorite", 30),
      	    		$config->setNested("polished-granite", 50),
      	    		$config->setNested("polished-andesite", 50),
      	    		$config->setNested("grass", 2),
      	    		$config->setNested("dirt", 1),
      	    		$config->setNested("coarse-dirt", 10),
      	    		$config->setNested("podzol", 5),
      	    		$config->setNested("water", 30),
      	    		$config->setNested("lava", 30),
      	    		$config->setNested("sand", 30),
      	    		$config->setNested("sandstone", 30),
      	    		$config->setNested("redsandstone", 30),
      	    		$config->setNested("smooth-sandstone", 30),
      	    		$config->setNested("chiseled-sandstone", 30),
      	    		$config->setNested("wool", 30),
      	    		$config->setNested("gold-block", 30),
      	    		$config->setNested("iron-block", 30),
      	    		$config->setNested("diamond-block", 30),
      	    		$config->setNested("coal-block", 30),
      	    		$config->setNested("redstone-block", 30),
      	    		$config->setNested("brick", 30),
      	    		$config->setNested("goldenapple", 30),
      	    		$config->setNested("enchantedapple", 30),
      	    		$config->setNested("steak", 30)
      	    	 ];
      	    	 $config->save(); 
	      }
    }
	
    public function storeShopNames(): void { 
              if(!file_exists($this->plugin->getDataFolder() . "/shopnames.yml")) {
		 $config = new Config($this->plugin->getDataFolder() . "/shopnames.yml", Config::YAML);
            	 $shop = [
      	    		$config->setNested("oak-logs", "log"),
      	    		$config->setNested("spruce-logs", "log"),
      	    		$config->setNested("birch-logs", "log"),
      	    		$config->setNested("jungle-logs", "log"),
      	    		$config->setNested("dark-logs", "log"),
      	    		$config->setNested("acacia-logs", "log"),
      	    		$config->setNested("oak-wood", "wood"),
      	    		$config->setNested("spruce-wood", "wood"),
      	    		$config->setNested("birch-wood", "wood"),
      	    		$config->setNested("jungle-wood", "wood"),
      	    		$config->setNested("dark-wood", "wood"),
      	    		$config->setNested("acacia-wood", "wood"),
      	    		$config->setNested("wool", "name"),
      	    		$config->setNested("orange-wool", "name"),
      	    		$config->setNested("magenta-wool", "name"),
      	    		$config->setNested("light-blue-wool", "name"),
      	    		$config->setNested("yellow-wool", "name"),
      	    		$config->setNested("lime-wool", "name"),
      	    		$config->setNested("pink-wool", "name"),
      	    		$config->setNested("gray-wool", "name"),
      	    		$config->setNested("light-gray-wool", "name"),
      	    		$config->setNested("cyan-wool", "name"),
      	    		$config->setNested("purple-wool", "name"),
      	    		$config->setNested("blue-wool", "name"),
      	    		$config->setNested("brown-wool", "name"),
      	    		$config->setNested("green-wool", "name"),
      	    		$config->setNested("red-wool", "name"),
      	    		$config->setNested("black-wool", "name"),
      	    		$config->setNested("stone", "stone"),
      	    		$config->setNested("cobble", "cobble"),
      	    		$config->setNested("quartz", "name"),
      	    		$config->setNested("obsidian", "name"),
      	    		$config->setNested("ice", "name"),
      	    		$config->setNested("diorite", "name"),
      	    		$config->setNested("granite", "name"),
      	    		$config->setNested("andesite", "name"),
      	    		$config->setNested("polished-diorite", "name"),
      	    		$config->setNested("polished-granite", "name"),
      	    		$config->setNested("polished-andesite", "name"),
      	    		$config->setNested("grass", "name"),
      	    		$config->setNested("dirt", "name"),
      	    		$config->setNested("coarse-dirt", "name"),
      	    		$config->setNested("podzol", "name"),
      	    		$config->setNested("water", "name"),
      	    		$config->setNested("lava", "name"),
      	    		$config->setNested("sand", "name"),
      	    		$config->setNested("sandstone", "name"),
      	    		$config->setNested("redsandstone", "name"),
      	    		$config->setNested("smooth-sandstone", "name"),
      	    		$config->setNested("chiseled-sandstone", "name"),
      	    		$config->setNested("gold-block", "name"),
      	    		$config->setNested("iron-block", "name"),
      	    		$config->setNested("diamond-block", "name"),
      	    		$config->setNested("coal-block", "name"),
      	    		$config->setNested("redstone-block", "name"),
      	    		$config->setNested("brick", "name"),
      	    		$config->setNested("goldenapple", "name"),
      	    		$config->setNested("enchantedapple", "name"),
      	    		$config->setNested("steak", "name")
      	    	 ];
      	    	 $config->save(); 
	      }
    }
}
