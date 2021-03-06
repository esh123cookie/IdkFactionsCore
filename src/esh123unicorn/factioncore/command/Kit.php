<?php

namespace esh123unicorn\factioncore\command;

use esh123unicorn\factioncore\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\command\Command;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;
use pocketmine\inventory\Inventory;
use pocketmine\item\Armor;
use pocketmine\item\Tool;
use pocketmine\math\Vector3;
use pocketmine\utils\config;

class Kit extends PluginCommand{

    private $owner;
    
    private $kit1 = [];
    private $kit2 = [];
    private $kit3 = [];
    private $kit4 = [];
    private $kit5 = [];
    
    private $config1;
    private $config2;
    private $config3;
    private $config4;
    private $config5;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("kit.use");
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
            if($sender->hasPermission("kit.use")) {
               $this->openKit($sender);   
            } else {
               $sender->sendMessage("§7(§c!§7) §cYou do not have permission to use this command");
            }
    }
    
    public function openKit(Player $sender) {
		$api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $sender, int $data = null){
		$result = $data;
		if($result === null){
			return true;
			}
			switch($result){
               case 0:
               $this->config1 = new Config($this->getPlugin()->kitFolder . "/kit1.yml", Config::YAML);
               if(!$sender->hasPermission($this->config1->get("perm"))){
                  $sender->sendMessage("§7(§c!§7) §cYou don't have permission to use this kit");
               }else{ 
	              if(!isset($this->kit1[$sender->getName()])){
	                 $this->kit1[$sender->getName()] = time() + $this->config1->get("cooldown"); //[time second] [time hours] [time minute] cool down to caim the kit
	                 $sender->sendMessage($this->config1->get("claim-message"));
                     $this->kit1Items($sender);
	              }else{
	                 if(time() < $this->kit1[$sender->getName()]){
	                    $minutes = ($this->kit1[$sender->getName()] - time()) / 60;
	                    $hours = ($this->kit1[$sender->getName()] - time()) / 60 * 60;
	                    $sender->sendTip("§7(§c!§7) §cCooldown §5" . (round($minutes)) . " §cminutes remaining");
	                 }else{
	                    unset($this->kit1[$sender->getName()]);																				
                     }
                  }
               }   
               break;
                    
               case 1:
               $this->config2 = new Config($this->getPlugin()->kitFolder . "/kit2.yml", Config::YAML);
               if(!$sender->hasPermission($this->config2->get("perm"))){
                  $sender->sendMessage("§7(§c!§7) §cYou don't have permission to use this kit");
               }else{ 
	              if(!isset($this->kit2[$sender->getName()])){
	                 $this->kit2[$sender->getName()] = time() + $this->config2->get("cooldown"); //[time second] [time hours] [time minute] cool down to caim the kit
	                 $sender->sendMessage($this->config2->get("claim-message"));
                     $this->kit2Items($sender);
	              }else{
	                 if(time() < $this->kit2[$sender->getName()]){
	                    $minutes = ($this->kit2[$sender->getName()] - time()) / 60;
	                    $hours = ($this->kit2[$sender->getName()] - time()) / 60 * 60;
	                    $sender->sendTip("§7(§c!§7) §cCooldown §5" . (round($minutes)) . " §cminutes remaining");
	                 }else{
	                    unset($this->kit2[$sender->getName()]);																				
                     }
                  }
               }   
               break;
                    
               case 2:
               $this->config3 = new Config($this->getPlugin()->kitFolder . "/kit3.yml", Config::YAML);
               if(!$sender->hasPermission($this->config3->get("perm"))){
                  $sender->sendMessage("§7(§c!§7) §cYou don't have permission to use this kit");
               }else{ 
	              if(!isset($this->kit3[$sender->getName()])){
	                 $this->kit3[$sender->getName()] = time() + $this->config3->get("cooldown"); //[time second] [time hours] [time minute] cool down to caim the kit
	                 $sender->sendMessage($this->config3->get("claim-message"));
                     $this->kit3Items($sender);
	              }else{
	                 if(time() < $this->kit3[$sender->getName()]){
	                    $minutes = ($this->kit3[$sender->getName()] - time()) / 60;
	                    $hours = ($this->kit3[$sender->getName()] - time()) / 60 * 60;
	                    $sender->sendTip("§7(§c!§7) §cCooldown §5" . (round($minutes)) . " §cminutes remaining");
	                 }else{
	                    unset($this->kit3[$sender->getName()]);																				
                     }
                  }
               }   
               break;
                    
               case 3:
               $this->config4 = new Config($this->getPlugin()->kitFolder . "/kit4.yml", Config::YAML);
               if(!$sender->hasPermission($this->config4->get("perm"))){
                  $sender->sendMessage("§7(§c!§7) §cYou don't have permission to use this kit");
               }else{ 
	              if(!isset($this->kit4[$sender->getName()])){
	                 $this->kit4[$sender->getName()] = time() + $this->config4->get("cooldown"); //[time second] [time hours] [time minute] cool down to caim the kit
	                 $sender->sendMessage($this->config4->get("claim-message"));
                     $this->kit4Items($sender);
	              }else{
	                 if(time() < $this->kit4[$sender->getName()]){
	                    $minutes = ($this->kit4[$sender->getName()] - time()) / 60;
	                    $hours = ($this->kit4[$sender->getName()] - time()) / 60 * 60;
	                    $sender->sendTip("§7(§c!§7) §cCooldown §5" . (round($minutes)) . " §cminutes remaining");
	                 }else{
	                    unset($this->kit4[$sender->getName()]);																				
                     }
                  }
               }   
               break;
                    
	       case 4:
               $this->config5 = new Config($this->getPlugin()->kitFolder . "/kit5.yml", Config::YAML);
               if(!$sender->hasPermission($this->config5->get("perm"))){
                  $sender->sendMessage("§7(§c!§7) §cYou don't have permission to use this kit");
               }else{ 
	              if(!isset($this->kit5[$sender->getName()])){
	                 $this->kit5[$sender->getName()] = time() + $this->config5->get("cooldown"); //[time second] [time hours] [time minute] cool down to caim the kit
	                 $sender->sendMessage($this->config5->get("claim-message"));
                     $this->kit5Items($sender);
	              }else{
	                 if(time() < $this->kit5[$sender->getName()]){
	                    $minutes = ($this->kit5[$sender->getName()] - time()) / 60;
	                    $hours = ($this->kit5[$sender->getName()] - time()) / 60 * 60;
	                    $sender->sendTip("§7(§c!§7) §cCooldown §5" . (round($minutes)) . " §cminutes remaining");
	                 }else{
	                    unset($this->kit5[$sender->getName()]);																				
                     }
                  }
               }   
               break;    
 	       }
	});
	$config = new Config($this->getPlugin()->kitFolder . "/kits.yml", Config::YAML);
	$id = new Config($this->getPlugin()->kitFolder . "/config.yml", Config::YAML);
        $kit1 = new Config($this->getPlugin()->kitFolder . "/kit1.yml", Config::YAML);
        $kit2 = new Config($this->getPlugin()->kitFolder . "/kit2.yml", Config::YAML);
        $kit3 = new Config($this->getPlugin()->kitFolder . "/kit3.yml", Config::YAML);
        $kit4 = new Config($this->getPlugin()->kitFolder . "/kit4.yml", Config::YAML);
        $kit5 = new Config($this->getPlugin()->kitFolder . "/kit5.yml", Config::YAML);
        $form->setTitle($config->get("title"));
	$form->setContent($config->get("content"));
	if(!isset($this->kit1[$sender->getName()])){
	   $form->addButton($sender->hasPermission($kit1->get("perm")) === true ? $config->get("button1")." \n " . $id->get("unlocked") : $config->get("button1")." \n " . $id->get("locked"));
	}elseif(($this->kit1[$sender->getName()] >= 0) and ($sender->hasPermission($kit1->get("perm")))){
	   $form->addButton($config->get("button1") . " \n§c " . (round(($this->kit1[$sender->getName()] - time()) / 60)). "Minutes");
	}
	if(!isset($this->kit2[$sender->getName()])){
	   $form->addButton($sender->hasPermission($kit2->get("perm")) === true ? $config->get("button2")." \n " . $id->get("unlocked") : $config->get("button2")." \n " . $id->get("locked"));
	}elseif(($this->kit2[$sender->getName()] >= 0) and ($sender->hasPermission($kit2->get("perm")))){
	    $form->addButton($config->get("button2") . " \n§c " . (round(($this->kit2[$sender->getName()] - time()) / 60)). "Minutes");
	}
	if(!isset($this->kit3[$sender->getName()])){
	   $form->addButton($sender->hasPermission($kit3->get("perm")) === true ? $config->get("button3")." \n " . $id->get("unlocked") : $config->get("button3")." \n " . $id->get("locked"));
	}elseif(($this->kit3[$sender->getName()] >= 0) and ($sender->hasPermission($kit3->get("perm")))){
	    $form->addButton($config->get("button3") . " \n§c " . (round(($this->kit3[$sender->getName()] - time()) / 60)). "Minutes");
	}
	if(!isset($this->kit4[$sender->getName()])){
	   $form->addButton($sender->hasPermission($kit4->get("perm")) === true ? $config->get("button4")." \n " . $id->get("unlocked") : $config->get("button4")." \n " . $id->get("locked"));
	}elseif(($this->kit4[$sender->getName()] >= 0) and ($sender->hasPermission($kit4->get("perm")))){
	    $form->addButton($config->get("button4") . " \n§c " . (round(($this->kit4[$sender->getName()] - time()) / 60)). "Minutes");
	}
	if(!isset($this->kit5[$sender->getName()])){
	   $form->addButton($sender->hasPermission($kit5->get("perm")) === true ? $config->get("button5")." \n " . $id->get("unlocked") : $config->get("button6")." \n " . $id->get("locked"));
	}elseif(($this->kit5[$sender->getName()] >= 0) and ($sender->hasPermission($kit5->get("perm")))){
	    $form->addButton($config->get("button5") . " \n§c " . (round(($this->kit5[$sender->getName()] - time()) / 60)). "Minutes");
	}
        $form->sendToPlayer($sender);
        return $form;
    }
	
    public function kit1Items(Player $player) { 
	       $config = new Config($this->getPlugin()->kitFolder . "/kit1.yml", Config::YAML);
	       $kits = new Config($this->getPlugin()->kitFolder . "/kits.yml", Config::YAML);
	       $swordench = Enchantment::getEnchantment($config->get("Swordenchant1"));
	       $armor = Enchantment::getEnchantment($config->get("Armorenchant1"));
	       $swordench2 = Enchantment::getEnchantment($config->get("Swordenchant2"));
	       $armor2 = Enchantment::getEnchantment($config->get("Armorenchant2"));
	       $tool = Enchantment::getEnchantment($config->get("Toolenchant1"));
	       $tool2 = Enchantment::getEnchantment($config->get("Toolenchant2"));
	    	
	       $inv = $player->getInventory();
	       $helmet = Item::get($config->get("helmet"), 0, 1);
	       $helmet->setCustomName($kits->get("button1"));
	       $helmet->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $helmet->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get($config->get("chestplate"), 0, 1);
	       $chest->setCustomName($kits->get("button1"));
	       $chest->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $chest->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get($config->get("leggings"), 0, 1);
	       $legs->setCustomName($kits->get("button1"));
	       $legs->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $legs->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get($config->get("boots"), 0, 1);
	       $boots->setCustomName($kits->get("button1"));
	       $boots->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $boots->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($boots);
		//sword
	       $sword = Item::get($config->get("sword"), 0, 1);
	       $sword->setCustomName($kits->get("button1"));
	       $sword->addEnchantment(new EnchantmentInstance($swordench, $config->get("Swordlevel1")));
	       $sword->addEnchantment(new EnchantmentInstance($swordench2, $config->get("Swordlevel2")));
               $player->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get($config->get("pickaxe"), 0, 1);
	       $pickaxe->setCustomName($kits->get("button1"));
	       $pickaxe->addEnchantment(new EnchantmentInstance($tool, $config->get("Toollevel1")));
	       $pickaxe->addEnchantment(new EnchantmentInstance($tool2, $config->get("Toollevel2")));
               $player->getInventory()->addItem($pickaxe);
		//axe
	       $axe = Item::get($config->get("axe"), 0, 1);
	       $axe->setCustomName($kits->get("button1"));
	       $axe->addEnchantment(new EnchantmentInstance($tool, $config->get("Toollevel1")));
	       $axe->addEnchantment(new EnchantmentInstance($tool2, $config->get("Toollevel2")));
               $player->getInventory()->addItem($axe);
		//hoe
	       $hoe = Item::get($config->get("hoe"), 0, 1);
	       $hoe->setCustomName($kits->get("button1"));
	       $hoe->addEnchantment(new EnchantmentInstance($tool, $config->get("Toollevel1")));
	       $hoe->addEnchantment(new EnchantmentInstance($tool2, $config->get("Toollevel2")));
               $player->getInventory()->addItem($hoe);
    }
	
    public function kit2Items(Player $player) { 
	       $config = new Config($this->getPlugin()->kitFolder . "/kit2.yml", Config::YAML);
	       $kits = new Config($this->getPlugin()->kitFolder . "/kits.yml", Config::YAML);
	       $swordench = Enchantment::getEnchantment($config->get("Swordenchant1"));
	       $armor = Enchantment::getEnchantment($config->get("Armorenchant1"));
	       $swordench2 = Enchantment::getEnchantment($config->get("Swordenchant2"));
	       $armor2 = Enchantment::getEnchantment($config->get("Armorenchant2"));
	       $tool = Enchantment::getEnchantment($config->get("Toolenchant1"));
	       $tool2 = Enchantment::getEnchantment($config->get("Toolenchant2"));
	    	
	       $inv = $player->getInventory();
	       $helmet = Item::get($config->get("helmet"), 0, 1);
	       $helmet->setCustomName($kits->get("button2"));
	       $helmet->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $helmet->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get($config->get("chestplate"), 0, 1);
	       $chest->setCustomName($kits->get("button2"));
	       $chest->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $chest->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get($config->get("leggings"), 0, 1);
	       $legs->setCustomName($kits->get("button2"));
	       $legs->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $legs->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get($config->get("boots"), 0, 1);
	       $boots->setCustomName($kits->get("button2"));
	       $boots->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $boots->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($boots);
		//sword
	       $sword = Item::get($config->get("sword"), 0, 1);
	       $sword->setCustomName($kits->get("button2"));
	       $sword->addEnchantment(new EnchantmentInstance($swordench, $config->get("Swordlevel1")));
	       $sword->addEnchantment(new EnchantmentInstance($swordench2, $config->get("Swordlevel2")));
               $player->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get($config->get("pickaxe"), 0, 1);
	       $pickaxe->setCustomName($kits->get("button2"));
	       $pickaxe->addEnchantment(new EnchantmentInstance($tool, $config->get("Toollevel1")));
	       $pickaxe->addEnchantment(new EnchantmentInstance($tool2, $config->get("Toollevel2")));
               $player->getInventory()->addItem($pickaxe);
		//axe
	       $axe = Item::get($config->get("axe"), 0, 1);
	       $axe->setCustomName($kits->get("button2"));
	       $axe->addEnchantment(new EnchantmentInstance($tool, $config->get("Toollevel1")));
	       $axe->addEnchantment(new EnchantmentInstance($tool2, $config->get("Toollevel2")));
               $player->getInventory()->addItem($axe);
		//hoe
	       $hoe = Item::get($config->get("hoe"), 0, 1);
	       $hoe->setCustomName($kits->get("button2"));
	       $hoe->addEnchantment(new EnchantmentInstance($tool, $config->get("Toollevel1")));
	       $hoe->addEnchantment(new EnchantmentInstance($tool2, $config->get("Toollevel2")));
               $player->getInventory()->addItem($hoe);
    }
	
    public function kit3Items(Player $player) { 
	       $config = new Config($this->getPlugin()->kitFolder . "/kit3.yml", Config::YAML);
	       $kits = new Config($this->getPlugin()->kitFolder . "/kits.yml", Config::YAML);
	       $swordench = Enchantment::getEnchantment($config->get("Swordenchant1"));
	       $armor = Enchantment::getEnchantment($config->get("Armorenchant1"));
	       $swordench2 = Enchantment::getEnchantment($config->get("Swordenchant2"));
	       $armor2 = Enchantment::getEnchantment($config->get("Armorenchant2"));
	       $tool = Enchantment::getEnchantment($config->get("Toolenchant1"));
	       $tool2 = Enchantment::getEnchantment($config->get("Toolenchant2"));
	    	
	       $inv = $player->getInventory();
	       $helmet = Item::get($config->get("helmet"), 0, 1);
	       $helmet->setCustomName($kits->get("button3"));
	       $helmet->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $helmet->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get($config->get("chestplate"), 0, 1);
	       $chest->setCustomName($kits->get("button3"));
	       $chest->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $chest->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get($config->get("leggings"), 0, 1);
	       $legs->setCustomName($kits->get("button3"));
	       $legs->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $legs->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get($config->get("boots"), 0, 1);
	       $boots->setCustomName($kits->get("button3"));
	       $boots->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $boots->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($boots);
		//sword
	       $sword = Item::get($config->get("sword"), 0, 1);
	       $sword->setCustomName($kits->get("button3"));
	       $sword->addEnchantment(new EnchantmentInstance($swordench, $config->get("Swordlevel1")));
	       $sword->addEnchantment(new EnchantmentInstance($swordench2, $config->get("Swordlevel2")));
               $player->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get($config->get("pickaxe"), 0, 1);
	       $pickaxe->setCustomName($kits->get("button3"));
	       $pickaxe->addEnchantment(new EnchantmentInstance($tool, $config->get("Toollevel1")));
	       $pickaxe->addEnchantment(new EnchantmentInstance($tool2, $config->get("Toollevel2")));
               $player->getInventory()->addItem($pickaxe);
		//axe
	       $axe = Item::get($config->get("axe"), 0, 1);
	       $axe->setCustomName($kits->get("button3"));
	       $axe->addEnchantment(new EnchantmentInstance($tool, $config->get("Toollevel1")));
	       $axe->addEnchantment(new EnchantmentInstance($tool2, $config->get("Toollevel2")));
               $player->getInventory()->addItem($axe);
		//hoe
	       $hoe = Item::get($config->get("hoe"), 0, 1);
	       $hoe->setCustomName($kits->get("button3"));
	       $hoe->addEnchantment(new EnchantmentInstance($tool, $config->get("Toollevel1")));
	       $hoe->addEnchantment(new EnchantmentInstance($tool2, $config->get("Toollevel2")));
               $player->getInventory()->addItem($hoe);
    }
	
    public function kit4Items(Player $player) { 
	       $config = new Config($this->getPlugin()->kitFolder . "/kit4.yml", Config::YAML);
	       $kits = new Config($this->getPlugin()->kitFolder . "/kits.yml", Config::YAML);
	       $swordench = Enchantment::getEnchantment($config->get("Swordenchant1"));
	       $armor = Enchantment::getEnchantment($config->get("Armorenchant1"));
	       $swordench2 = Enchantment::getEnchantment($config->get("Swordenchant2"));
	       $armor2 = Enchantment::getEnchantment($config->get("Armorenchant2"));
	       $tool = Enchantment::getEnchantment($config->get("Toolenchant1"));
	       $tool2 = Enchantment::getEnchantment($config->get("Toolenchant2"));
	    	
	       $inv = $player->getInventory();
	       $helmet = Item::get($config->get("helmet"), 0, 1);
	       $helmet->setCustomName($kits->get("button4"));
	       $helmet->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $helmet->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get($config->get("chestplate"), 0, 1);
	       $chest->setCustomName($kits->get("button4"));
	       $chest->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $chest->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get($config->get("leggings"), 0, 1);
	       $legs->setCustomName($kits->get("button4"));
	       $legs->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $legs->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get($config->get("boots"), 0, 1);
	       $boots->setCustomName($kits->get("button4"));
	       $boots->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $boots->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($boots);
		//sword
	       $sword = Item::get($config->get("sword"), 0, 1);
	       $sword->setCustomName($kits->get("button4"));
	       $sword->addEnchantment(new EnchantmentInstance($swordench, $config->get("Swordlevel1")));
	       $sword->addEnchantment(new EnchantmentInstance($swordench2, $config->get("Swordlevel2")));
               $player->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get($config->get("pickaxe"), 0, 1);
	       $pickaxe->setCustomName($kits->get("button4"));
	       $pickaxe->addEnchantment(new EnchantmentInstance($tool, $config->get("Toollevel1")));
	       $pickaxe->addEnchantment(new EnchantmentInstance($tool2, $config->get("Toollevel2")));
               $player->getInventory()->addItem($pickaxe);
		//axe
	       $axe = Item::get($config->get("axe"), 0, 1);
	       $axe->setCustomName($kits->get("button4"));
	       $axe->addEnchantment(new EnchantmentInstance($tool, $config->get("Toollevel1")));
	       $axe->addEnchantment(new EnchantmentInstance($tool2, $config->get("Toollevel2")));
               $player->getInventory()->addItem($axe);
		//hoe
	       $hoe = Item::get($config->get("hoe"), 0, 1);
	       $hoe->setCustomName($kits->get("button4"));
	       $hoe->addEnchantment(new EnchantmentInstance($tool, $config->get("Toollevel1")));
	       $hoe->addEnchantment(new EnchantmentInstance($tool2, $config->get("Toollevel2")));
               $player->getInventory()->addItem($hoe);
    }
	
    public function kit5Items(Player $player) { 
	       $config = new Config($this->getPlugin()->kitFolder . "/kit5.yml", Config::YAML);
	       $kits = new Config($this->getPlugin()->kitFolder . "/kits.yml", Config::YAML);
	       $swordench = Enchantment::getEnchantment($config->get("Swordenchant1"));
	       $armor = Enchantment::getEnchantment($config->get("Armorenchant1"));
	       $swordench2 = Enchantment::getEnchantment($config->get("Swordenchant2"));
	       $armor2 = Enchantment::getEnchantment($config->get("Armorenchant2"));
	       $tool = Enchantment::getEnchantment($config->get("Toolenchant1"));
	       $tool2 = Enchantment::getEnchantment($config->get("Toolenchant2"));
	    	
	       $inv = $player->getInventory();
	       $helmet = Item::get($config->get("helmet"), 0, 1);
	       $helmet->setCustomName($kits->get("button5"));
	       $helmet->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $helmet->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get($config->get("chestplate"), 0, 1);
	       $chest->setCustomName($kits->get("button5"));
	       $chest->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $chest->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get($config->get("leggings"), 0, 1);
	       $legs->setCustomName($kits->get("button5"));
	       $legs->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $legs->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get($config->get("boots"), 0, 1);
	       $boots->setCustomName($kits->get("button5"));
	       $boots->addEnchantment(new EnchantmentInstance($armor, $config->get("Armorlevel1")));
	       $boots->addEnchantment(new EnchantmentInstance($armor2, $config->get("Armorlevel2")));
               $player->getInventory()->addItem($boots);
		//sword
	       $sword = Item::get($config->get("sword"), 0, 1);
	       $sword->setCustomName($kits->get("button5"));
	       $sword->addEnchantment(new EnchantmentInstance($swordench, $config->get("Swordlevel1")));
	       $sword->addEnchantment(new EnchantmentInstance($swordench2, $config->get("Swordlevel2")));
               $player->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get($config->get("pickaxe"), 0, 1);
	       $pickaxe->setCustomName($kits->get("button5"));
	       $pickaxe->addEnchantment(new EnchantmentInstance($tool, $config->get("Toollevel1")));
	       $pickaxe->addEnchantment(new EnchantmentInstance($tool2, $config->get("Toollevel2")));
               $player->getInventory()->addItem($pickaxe);
		//axe
	       $axe = Item::get($config->get("axe"), 0, 1);
	       $axe->setCustomName($kits->get("button5"));
	       $axe->addEnchantment(new EnchantmentInstance($tool, $config->get("Toollevel1")));
	       $axe->addEnchantment(new EnchantmentInstance($tool2, $config->get("Toollevel2")));
               $player->getInventory()->addItem($axe);
		//hoe
	       $hoe = Item::get($config->get("hoe"), 0, 1);
	       $hoe->setCustomName($kits->get("button5"));
	       $hoe->addEnchantment(new EnchantmentInstance($tool, $config->get("Toollevel1")));
	       $hoe->addEnchantment(new EnchantmentInstance($tool2, $config->get("Toollevel2")));
               $player->getInventory()->addItem($hoe);
    }
}
