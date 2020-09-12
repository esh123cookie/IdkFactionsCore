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
		$form = $api->createSimpleForm(function (Player $sender, int $data = null){
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
            }
        });
        $form->setTitle($this->config->get("title"));
	$form->setContent($name->get("content") . "§bCurrent Money§8:§e ". EconomyAPI::getInstance()->myMoney($player));
	    
	//logs
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
	    
	//blocks
        $form->addButton($name->get("polished-diorite"));
        $form->addButton($name->get("polished-granite"));
        $form->addButton($name->get("polished-andesite"));   
        $form->addButton($name->get("grass"));
        $form->addButton($name->get("dirt"));
        $form->addButton($name->get("coarse-dirt"));
        $form->addButton($name->get("podzol"));
        $form->addButton($name->get("water"));
        $form->addButton($name->get("lava"));
   
        $form->addButton("§cExit");
        $form->sendToPlayer($player);
    }
	
    public function walls(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/config.yml", Config::YAML);
      $itemName = $this->config->get("wall-gen-button");
      $price = $this->config->get("wall-price");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get($config->get("wall-id"), $data[1])->setCustomName($config->get("gen-name"));
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
	
    public function oaklog(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("oak-log");
      $price = $p->get("logs");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(17, 0, $data[1])->setCustomName($config->get("gen-name"));
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
    public function sprucelog(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("spruce-log");
      $price = $p->get("logs");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(17, 1, $data[1])->setCustomName($config->get("gen-name"));
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
    public function birchlog(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("birch-log");
      $price = $p->get("logs");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(17, 2, $data[1])->setCustomName($config->get("gen-name"));
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
    public function junglelog(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("jungle-log");
      $price = $p->get("logs");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(17, 3, $data[1])->setCustomName($config->get("gen-name"));
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
    public function darklog(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("dark-log");
      $price = $p->get("logs");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(162, 1, $data[1])->setCustomName($config->get("gen-name"));
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
    public function acacialog(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("acacia-log");
      $price = $p->get("logs");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(162, 0, $data[1])->setCustomName($config->get("gen-name"));
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
	
    public function oakwood(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("oak-wood");
      $price = $p->get("wood");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(5, 0, $data[1])->setCustomName($config->get("gen-name"));
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
    public function sprucewood(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("spruce-wood");
      $price = $p->get("wood");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(5, 1, $data[1])->setCustomName($config->get("gen-name"));
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
    public function birchwood(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("birch-wood");
      $price = $p->get("wood");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(5, 2, $data[1])->setCustomName($config->get("gen-name"));
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
    public function junglewood(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("jungle-wood");
      $price = $p->get("wood");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(5, 3, $data[1])->setCustomName($config->get("gen-name"));
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
    public function darkwood(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("dark-wood");
      $price = $p->get("wood");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(5, 5, $data[1])->setCustomName($config->get("gen-name"));
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
    public function acaciawood(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("acacia-wood");
      $price = $p->get("wood");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(5, 4, $data[1])->setCustomName($config->get("gen-name"));
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
	
    public function wool(Player $player) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 0, $data[1])->setCustomName($config->get("gen-name"));
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
    public function oranage(Player $player) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("orange-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 1, $data[1])->setCustomName($config->get("gen-name"));
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
    public function magenta(Player $player) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("magenta-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 2, $data[1])->setCustomName($config->get("gen-name"));
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
    public function lightblue(Player $player) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("light-blue-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 3, $data[1])->setCustomName($config->get("gen-name"));
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
    public function yellow(Player $player) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("yellow-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 4, $data[1])->setCustomName($config->get("gen-name"));
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
    public function lime(Player $player) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("lime-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 5, $data[1])->setCustomName($config->get("gen-name"));
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
    public function pink(Player $player) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("pink-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 6, $data[1])->setCustomName($config->get("gen-name"));
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
    public function gray(Player $player) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("gray-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 7, $data[1])->setCustomName($config->get("gen-name"));
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
    public function lightgray(Player $player) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("light-gray-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 8, $data[1])->setCustomName($config->get("gen-name"));
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
    public function cyan(Player $player) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("cyan-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 9, $data[1])->setCustomName($config->get("gen-name"));
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
    public function purple(Player $player) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("purple-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 10, $data[1])->setCustomName($config->get("gen-name"));
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
    public function blue(Player $player) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("blue-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 11, $data[1])->setCustomName($config->get("gen-name"));
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
    public function brown(Player $player) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("brown-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 12, $data[1])->setCustomName($config->get("gen-name"));
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
    public function green(Player $player) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("green-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 13, $data[1])->setCustomName($config->get("gen-name"));
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
    public function red(Player $player) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("red-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 14, $data[1])->setCustomName($config->get("gen-name"));
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
    public function black(Player $player) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("black-wool");
      $price = $p->get("wool");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(35, 15, $data[1])->setCustomName($config->get("gen-name"));
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
	
    public function stone(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("stone");
      $price = $p->get("stone");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(1, 0, $data[1])->setCustomName($config->get("gen-name"));
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
    public function cobble(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("cobble");
      $price = $p->get("cobble");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(4, 0, $data[1])->setCustomName($config->get("gen-name"));
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
    public function quartz(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("quartz");
      $price = $p->get("quartz");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(155, 0, $data[1])->setCustomName($config->get("gen-name"));
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
    public function obsidian(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("obsidian");
      $price = $p->get("obsidian");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(49, 0, $data[1])->setCustomName($config->get("gen-name"));
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
    public function ice(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("ice");
      $price = $p->get("ice");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(79, 0, $data[1])->setCustomName($config->get("gen-name"));
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
    public function diorite(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("diorite");
      $price = $p->get("diorite");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(1, 3, $data[1])->setCustomName($config->get("gen-name"));
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
    public function granite(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("granite");
      $price = $p->get("granite");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(1, 1, $data[1])->setCustomName($config->get("gen-name"));
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
    public function andesite(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("andesite");
      $price = $p->get("andesite");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(1, 5, $data[1])->setCustomName($config->get("gen-name"));
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
    public function pdiorite(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("polished-diorite");
      $price = $p->get("polished-diorite");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(1, 4, $data[1])->setCustomName($config->get("gen-name"));
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
    public function pgranite(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("polished-granite");
      $price = $p->get("polished-granite");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(1, 2, $data[1])->setCustomName($config->get("gen-name"));
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
    public function pandesite(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("polished-andesite");
      $price = $p->get("polished-andesite");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(1, 6, $data[1])->setCustomName($config->get("gen-name"));
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
    public function grass(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("grass");
      $price = $p->get("grass");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(2, 0, $data[1])->setCustomName($config->get("gen-name"));
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
    public function dirt(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("dirt");
      $price = $p->get("dirt");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(3, 0, $data[1])->setCustomName($config->get("gen-name"));
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
    public function coarsedirt(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("coarse-dirt");
      $price = $p->get("coarse-dirt");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(3, 1, $data[1])->setCustomName($config->get("gen-name"));
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
    public function podzol(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("podzol");
      $price = $p->get("podzol");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(243, 0, $data[1])->setCustomName($config->get("gen-name"));
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
    public function water(Player $player) { 
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("water");
      $price = $p->get("water");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(8, 0, $data[1])->setCustomName($config->get("gen-name"));
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
    public function lava(Player $player) {
      $config = new Config($this->getPlugin()->getDataFolder() . "/shopnames.yml", Config::YAML);
      $p = new Config($this->getPlugin()->getDataFolder() . "/prices.yml", Config::YAML);
      $itemName = $config->get("lava");
      $price = $p->get("lava");
      $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
      $f = $api->createCustomForm(function(Player $sender, ?array $data){
      if(!isset($data)) return;
	  if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($price * $data[1])){
	     $sender->sendMessage("§7(§a!§7) §aYou purchased $data[1] " . $itemName);
	     $item = Item::get(10, 0, $data[1])->setCustomName($config->get("gen-name"));
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
