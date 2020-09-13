<?php

namespace esh123unicorn\factioncore\command;

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
use pocketmine\block\BlockFactory;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\Armor;
use pocketmine\item\Tool;
use pocketmine\item\ItemFactory;

//form ui
use jojoe77777\FormAPI;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;

use onebone\economyapi\EconomyAPI;

class Shop extends PluginCommand{

    private $owner;
    
    private $config;
    
    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("shop.use");
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
            if($sender->hasPermission("shop.use")) {
               $this->openShop($sender);   
            } else {
               $sender->sendMessage("§7(§c!§7) §cYou do not have permission to use this command");
            }
    }
    
    public function openShop(Player $player) { 
        $this->config = new Config($this->getPlugin()->getDataFolder() . "/shop.yml", Config::YAML);
		$api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null){
		$result = $data;
		if($result === null){
			return true;
			}
			switch($result){
               case 0:
            $this->walls($player);
               break;
               case 0:
            $this->building($player);
               break;
               case 0:
            $this->misk($player);
               break;
            }
        });
        $form->setTitle($this->config->get("title"));
	$form->setContent($this->config->get("content") . "§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($player));
        $form->addButton($this->config->get("wall-gen-button"));
	$form->addButton($this->config->get("building-button"));
        $form->addButton($this->config->get("misk-button"));
        $form->addButton("§cExit");
        $form->sendToPlayer($player);
    }
	
    public function misk(Player $player) { 
        $this->config = new Config($this->getPlugin()->getDataFolder() . "/shop.yml", Config::YAML);
		$name = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
		$api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null){
		$result = $data;
		if($result === null){
			return true;
			}
			switch($result){
               case 0:
            $this->goldenapple($player);
               break;
               case 1:
            $this->enchantedapple($player);
               break;
               case 2:
            $this->steak($player);
               break;
            }
        });
        $form->setTitle($this->config->get("title"));
	$form->setContent($this->config->get("content") . "§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($player));
        $form->addButton($name->get("goldenapple"));
	$form->addButton($name->get("enchantedapple"));	
	$form->addButton($name->get("steak"));	
        $form->sendToPlayer($player);
    }
	
    public function goldenapple(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("goldenapple");
      $price = $p->get("goldenapple");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("goldenapple");
      $price = $p->get("goldenapple");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(322, 1, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function enchantedapple(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("enchantedapple");
      $price = $p->get("enchantedapple");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("enchantedapple");
      $price = $p->get("enchantedapple");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(466, 1, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function steak(Player $sender) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("steak");
      $price = $p->get("steak");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("steak");
      $price = $p->get("steak");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(364, 1, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
	    
    public function building(Player $player) { 
        $this->config = new Config($this->getPlugin()->getDataFolder() . "/shop.yml", Config::YAML);
	$name = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
		$api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $sender, int $data = null){
		$result = $data;
		if($result === null){
			return true;
			}
			switch($result){
               case 0:
            $this->oaklog($player);
               break;
               case 1:
            $this->sprucelog($player);
               break;
               case 2:
            $this->birchlog($player);
               break;
               case 3:
            $this->junglelog($player);
               break;
               case 3:
            $this->darklog($player);
               break;
               case 5:
            $this->acacialog($player);
               break;
	//wood							
               case 0:
            $this->oakwood($player);
               break;
               case 1:
            $this->sprucewood($player);
               break;
               case 2:
            $this->birchwood($player);
               break;
               case 3:
            $this->junglewood($player);
               break;
               case 3:
            $this->darkwood($player);
               break;
               case 5:
            $this->acaciawood($player);
               break;		
	//wool
               case 6:
            $this->wool($player);
               break;	
               case 7:
            $this->orange($player);
               break;	
               case 8:
            $this->magenta($player);
               break;	
               case 9:
            $this->lightblue($player);
               break;	
               case 10:
            $this->yellow($player);
               break;	
               case 11:
            $this->lime($player);
               break;	
               case 12:
            $this->pink($player);
               break;	
               case 13:
            $this->gray($player);
               break;	
               case 14:
            $this->lightgray($player);
               break;	
               case 15:
            $this->cyan($player);
               break;	
               case 16:
            $this->purple($player);
               break;
               case 17:
            $this->blue($player);
               break;
               case 18:
            $this->brown($player);
               break;
               case 19:
            $this->green($player);
               break;
               case 20:
            $this->red($player);
               break;
               case 21:
            $this->black($player);
               break;				
	//blocks
               case 22:
            $this->stone($player);
               break;	
               case 23:
            $this->cobble($player);
               break;	
               case 24:
            $this->quartz($player);
               break;	
               case 25:
            $this->obsidian($player);
               break;	
               case 26:
            $this->ice($player);
               break;	
               case 27:
            $this->diorite($player);
               break;	
               case 28:
            $this->granite($player);
               break;	
               case 29:
            $this->andesite($player);
               break;				
               case 30:
            $this->pdiorite($player);
               break;	
               case 31:
            $this->pgranite($player);
               break;	
               case 32:
            $this->pandesite($player);
               break;	
               case 33:
            $this->grass($player);
               break;	
               case 34:
            $this->dirt($player);
               break;	
               case 35:
            $this->coarsedirt($player);
               break;	
               case 36:
            $this->podzol($player);
               break;	
               case 37:
            $this->water($player);
               break;	
               case 38:
            $this->lava($player);
               break;				
               case 39:
            $this->sand($player);
               break;	
               case 40:
            $this->sandstone($player);
               break;
               case 41:
            $this->redsandstone($player);
               break;	
               case 42:
            $this->smoothsandstone($player);
               break;	
               case 43:
            $this->chiseledsandstone($player);
               break;	
               case 44:
            $this->gold($player);
               break;	
               case 45:
            $this->iron($player);
               break;	
               case 46:
            $this->diamond($player);
               break;	
               case 47:
            $this->coal($player);
               break;	
               case 48:
            $this->redstone($player);
               break;	
               case 49:
            $this->brick($player);
               break;	
               case 50:
	//exit
               break;
            }
        });
        $form->setTitle($this->config->get("title"));
	$form->setContent($this->config->get("content") . "§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($player));
        $form->addButton($name->get("oak-log"));
	$form->addButton($name->get("spruce-log"));
        $form->addButton($name->get("birch-log"));
        $form->addButton($name->get("jungle-log"));
        $form->addButton($name->get("dark-log"));
        $form->addButton($name->get("acacia-log"));
        $form->addButton($name->get("oak-wood"));
	$form->addButton($name->get("spruce-wood"));
        $form->addButton($name->get("birch-wood"));
        $form->addButton($name->get("jungle-wood"));
        $form->addButton($name->get("dark-wood"));
        $form->addButton($name->get("acacia-wood"));
        $form->addButton($name->get("wool"));
        $form->addButton($name->get("orange-wool"));
        $form->addButton($name->get("magenta-wool"));
        $form->addButton($name->get("light-blue-wool"));
        $form->addButton($name->get("yellow-wool"));
        $form->addButton($name->get("lime-wool"));
        $form->addButton($name->get("pink-wool"));
        $form->addButton($name->get("gray-wool"));
        $form->addButton($name->get("light-gray-wool"));
        $form->addButton($name->get("cyan-wool"));
        $form->addButton($name->get("purple-wool"));
        $form->addButton($name->get("blue-wool"));
        $form->addButton($name->get("brown-wool"));
        $form->addButton($name->get("green-wool"));
        $form->addButton($name->get("red-wool"));
        $form->addButton($name->get("black-wool"));
        $form->addButton($name->get("stone"));
        $form->addButton($name->get("cobble"));
        $form->addButton($name->get("quartz"));
        $form->addButton($name->get("obsidian"));
        $form->addButton($name->get("ice"));
        $form->addButton($name->get("diorite"));
        $form->addButton($name->get("granite"));
        $form->addButton($name->get("andesite"));
        $form->addButton($name->get("polished-diorite"));
        $form->addButton($name->get("polished-granite"));
        $form->addButton($name->get("polished-andesite"));   
        $form->addButton($name->get("grass"));
        $form->addButton($name->get("dirt"));
        $form->addButton($name->get("coarse-dirt"));
        $form->addButton($name->get("podzol"));
        $form->addButton($name->get("water"));
        $form->addButton($name->get("lava"));
        $form->addButton($name->get("sand"));
        $form->addButton($name->get("sandstone"));
        $form->addButton($name->get("redsandstone"));
        $form->addButton($name->get("smooth-sandstone"));
        $form->addButton($name->get("chiseled-sandstone"));
        $form->addButton($name->get("gold-block"));
        $form->addButton($name->get("iron-block"));
        $form->addButton($name->get("diamond-block"));
        $form->addButton($name->get("coal-block"));
        $form->addButton($name->get("redstone-block"));
        $form->addButton($name->get("brick"));
        $form->addButton("§cExit");
        $form->sendToPlayer($player);
    }
	
    public function walls(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/config.yml", Config::YAML);
      $itemName = $this->config->get("wall-gen-button");
      $price = $this->config->get("wall-price");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/config.yml", Config::YAML);
      $itemName = $this->config->get("wall-gen-button");
      $price = $this->config->get("wall-price");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get((int) $config->get("gen-id"), (int) $config->get("gen-meta"), $data[1]);
	     $item->setCustomName($config->get("gen-name"));
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
	
    public function oaklog(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("oak-log");
      $price = $p->get("logs");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("oak-log");
      $price = $p->get("logs");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(17, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function sprucelog(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("spruce-log");
      $price = $p->get("logs");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("spruce-log");
      $price = $p->get("logs");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(17, 1, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function birchlog(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("birch-log");
      $price = $p->get("logs");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("birch-log");
      $price = $p->get("logs");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(17, 2, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function junglelog(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("jungle-log");
      $price = $p->get("logs");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("jungle-log");
      $price = $p->get("logs");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(17, 3, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function darklog(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("dark-log");
      $price = $p->get("logs");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("dark-log");
      $price = $p->get("logs");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(162, 1, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function acacialog(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("acacia-log");
      $price = $p->get("logs");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("acacia-log");
      $price = $p->get("logs");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(162, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
	
    public function oakwood(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("oak-wood");
      $price = $p->get("wood");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("oak-wood");
      $price = $p->get("wood");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(5, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function sprucewood(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("spruce-wood");
      $price = $p->get("wood");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("spruce-wood");
      $price = $p->get("wood");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(5, 1, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function birchwood(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("birch-wood");
      $price = $p->get("wood");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("birch-wood");
      $price = $p->get("wood");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(5, 2, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function junglewood(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("jungle-wood");
      $price = $p->get("wood");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("jungle-wood");
      $price = $p->get("wood");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(5, 3, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function darkwood(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("dark-wood");
      $price = $p->get("wood");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("dark-wood");
      $price = $p->get("wood");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(5, 5, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function acaciawood(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("acacia-wood");
      $price = $p->get("wood");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("acacia-wood");
      $price = $p->get("wood");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(5, 4, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
	
    public function wool(Player $sender) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("wool");
      $price = $p->get("wool");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function oranage(Player $sender) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("orange-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("orange-wool");
      $price = $p->get("wool");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 1, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function magenta(Player $sender) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("magenta-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("magenta-wool");
      $price = $p->get("wool");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 2, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function lightblue(Player $sender) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("light-blue-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("light-blue-wool");
      $price = $p->get("wool");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 3, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function yellow(Player $sender) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("yellow-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("yellow-wool");
      $price = $p->get("wool");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 4, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function lime(Player $sender) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("lime-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("lime-wool");
      $price = $p->get("wool");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 5, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function pink(Player $sender) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("pink-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("pink-wool");
      $price = $p->get("wool");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 6, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function gray(Player $sender) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("gray-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("gray-wool");
      $price = $p->get("wool");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 7, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function lightgray(Player $sender) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("light-gray-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("light-gray-wool");
      $price = $p->get("wool");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 8, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function cyan(Player $sender) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("cyan-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("cyan-wool");
      $price = $p->get("wool");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 9, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function purple(Player $sender) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("purple-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("purple-wool");
      $price = $p->get("wool");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 10, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function blue(Player $sender) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("blue-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("blue-wool");
      $price = $p->get("wool");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 11, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function brown(Player $sender) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("brown-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("brown-wool");
      $price = $p->get("wool");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 12, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function green(Player $sender) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("green-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("green-wool");
      $price = $p->get("wool");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 13, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function red(Player $sender) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("red-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("red-wool");
      $price = $p->get("wool");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 14, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function black(Player $sender) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("black-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("black-wool");
      $price = $p->get("wool");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 15, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
	
    public function stone(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("stone");
      $price = $p->get("stone");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("stone");
      $price = $p->get("stone");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(1, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function cobble(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("cobble");
      $price = $p->get("cobble");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("cobble");
      $price = $p->get("cobble");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(4, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function quartz(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("quartz");
      $price = $p->get("quartz");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("quartz");
      $price = $p->get("quartz");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(155, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function obsidian(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("obsidian");
      $price = $p->get("obsidian");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("obsidian");
      $price = $p->get("obsidian");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(49, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function ice(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("ice");
      $price = $p->get("ice");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("ice");
      $price = $p->get("ice");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(79, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function diorite(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("diorite");
      $price = $p->get("diorite");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("diorite");
      $price = $p->get("diorite");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(1, 3, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function granite(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("granite");
      $price = $p->get("granite");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("granite");
      $price = $p->get("granite");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(1, 1, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function andesite(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("andesite");
      $price = $p->get("andesite");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("andesite");
      $price = $p->get("andesite");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(1, 5, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function pdiorite(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("polished-diorite");
      $price = $p->get("polished-diorite");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("polished-diorite");
      $price = $p->get("polished-diorite");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(1, 4, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function pgranite(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("polished-granite");
      $price = $p->get("polished-granite");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("polished-granite");
      $price = $p->get("polished-granite");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(1, 2, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function pandesite(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("polished-andesite");
      $price = $p->get("polished-andesite");
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("polished-andesite");
      $price = $p->get("polished-andesite");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("polished-andesite");
      $price = $p->get("polished-andesite");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(1, 6, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function grass(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("grass");
      $price = $p->get("grass");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("grass");
      $price = $p->get("grass");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(2, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function dirt(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("dirt");
      $price = $p->get("dirt");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("dirt");
      $price = $p->get("dirt");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(3, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function coarsedirt(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("coarse-dirt");
      $price = $p->get("coarse-dirt");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("coarse-dirt");
      $price = $p->get("coarse-dirt");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(3, 1, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function podzol(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("podzol");
      $price = $p->get("podzol");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("podzol");
      $price = $p->get("podzol");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(243, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function water(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("water");
      $price = $p->get("water");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("water");
      $price = $p->get("water");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(8, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function lava(Player $sender) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("lava");
      $price = $p->get("lava");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("lava");
      $price = $p->get("lava");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(10, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
	
    public function sand(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("sand");
      $price = $p->get("sand");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("sand");
      $price = $p->get("sand");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(12, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function sandstone(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("sandstone");
      $price = $p->get("sandstone");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("sandstone");
      $price = $p->get("sandstone");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(24, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function redsandstone(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("redsandstone");
      $price = $p->get("redsandstone");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("redsandstone");
      $price = $p->get("redsandstone");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(179, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function smoothsandstone(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("smooth-sandstone");
      $price = $p->get("smooth-sandstone");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("smooth-sandstone");
      $price = $p->get("smooth-sandstone");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(24, 2, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function chiseledsandstone(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("chiseled-sandstone");
      $price = $p->get("chiseled-sandstone");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("chiseled-sandstone");
      $price = $p->get("chiseled-sandstone");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(24, 1, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function gold(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("gold-block");
      $price = $p->get("gold-block");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("gold-block");
      $price = $p->get("gold-block");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(41, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function iron(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("iron-block");
      $price = $p->get("iron-block");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("iron-block");
      $price = $p->get("iron-block");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(42, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function diamond(Player $sender) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("diamond-block");
      $price = $p->get("diamond-block");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("diamond-block");
      $price = $p->get("diamond-block");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(57, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function coal(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("coal-block");
      $price = $p->get("coal-block");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("coal-block");
      $price = $p->get("coal-block");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(173, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function redstone(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("redstone-block");
      $price = $p->get("redstone-block");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("redstone-block");
      $price = $p->get("redstone-block");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(152, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
    public function brick(Player $sender) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("brick");
      $price = $p->get("brick");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("brick");
      $price = $p->get("brick");
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(45, 0, $data[1]);
	     $sender->getInventory()->addItem($item);
             EconomyAPI::getInstance()->reduceMoney($sender, ($price * $data[1]));
	  }else{
	     $sender->sendMessage("§7(§c!§7) §cYou do not have enough money to buy $data[1] " . $itemName);
             }
	  });
	  $f->setTitle($this->config->get("title"));
	  $f->addLabel("§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($sender) . "\n\n§aPrice§7: §e" . $price);
      	  $f->addInput("Amount: ");
	  $f->sendToPlayer($sender);
    }
}
