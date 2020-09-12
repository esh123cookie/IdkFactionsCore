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
    
    public function walls(Player $player) { 
      $config = new Config($this->plugin->getDataFolder() . "/config.yml", Config::YAML);
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
}
