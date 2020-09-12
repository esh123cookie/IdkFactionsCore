<?php

namespace esh123unicorn\factioncore\commands;

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

class Kit extends PluginCommand{

    private $owner;
    
    private $kit1 = [];
    private $kit2 = [];
    private $kit3 = [];
    private $kit4 = [];
    private $kit5 = [];
    
    private $config;

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
               $this->config = new Config($this->getPlugin()->kitFolder() . "/kit1.yml", Config::YAML);
	           $tools = Enchantment::getEnchantment($this->config->get("Swordenchant1"));
	           $armor = Enchantment::getEnchantment($this->config->get("Armorenchant1"));
	           $tools2 = Enchantment::getEnchantment($this->config->get("Swordenchant2"));
	           $armor2 = Enchantment::getEnchantment($this->config->get("Armorenchant2"));
               
               if(!$sender->hasPermission($this->config->get("perm"))){
                  $sender->sendMessage("§7(§c!§7) §cYou don't have permission to use this kit");
               }else{ 
	              if(!isset($this->kit1[$sender->getName()])){
	                 $this->kit1[$sender->getName()] = time() + $this->config->get("cooldown"); //[time second] [time hours] [time minute] cool down to caim the kit
	                 $sender->sendMessage($this->config->get("claim-message"));
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
               $this->config = new Config($this->getPlugin()->kitFolder() . "/kit2.yml", Config::YAML);
	           $tools = Enchantment::getEnchantment($this->config->get("Swordenchant1"));
	           $armor = Enchantment::getEnchantment($this->config->get("Armorenchant1"));
	           $tools2 = Enchantment::getEnchantment($this->config->get("Swordenchant2"));
	           $armor2 = Enchantment::getEnchantment($this->config->get("Armorenchant2"));
               
               if(!$sender->hasPermission($this->config->get("perm"))){
                  $sender->sendMessage("§7(§c!§7) §cYou don't have permission to use this kit");
               }else{ 
	              if(!isset($this->kit2[$sender->getName()])){
	                 $this->kit2[$sender->getName()] = time() + $this->config->get("cooldown"); //[time second] [time hours] [time minute] cool down to caim the kit
	                 $sender->sendMessage($this->config->get("claim-message"));
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
               $this->config = new Config($this->getPlugin()->kitFolder() . "/kit3.yml", Config::YAML);
	           $tools = Enchantment::getEnchantment($this->config->get("Swordenchant1"));
	           $armor = Enchantment::getEnchantment($this->config->get("Armorenchant1"));
	           $tools2 = Enchantment::getEnchantment($this->config->get("Swordenchant2"));
	           $armor2 = Enchantment::getEnchantment($this->config->get("Armorenchant2"));
               
               if(!$sender->hasPermission($this->config->get("perm"))){
                  $sender->sendMessage("§7(§c!§7) §cYou don't have permission to use this kit");
               }else{ 
	              if(!isset($this->kit3[$sender->getName()])){
	                 $this->kit3[$sender->getName()] = time() + $this->config->get("cooldown"); //[time second] [time hours] [time minute] cool down to caim the kit
	                 $sender->sendMessage($this->config->get("claim-message"));
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
                    
               case 0:
               $this->config = new Config($this->getPlugin()->kitFolder() . "/kit4.yml", Config::YAML);
	           $tools = Enchantment::getEnchantment($this->config->get("Swordenchant1"));
	           $armor = Enchantment::getEnchantment($this->config->get("Armorenchant1"));
	           $tools2 = Enchantment::getEnchantment($this->config->get("Swordenchant2"));
	           $armor2 = Enchantment::getEnchantment($this->config->get("Armorenchant2"));
               
               if(!$sender->hasPermission($this->config->get("perm"))){
                  $sender->sendMessage("§7(§c!§7) §cYou don't have permission to use this kit");
               }else{ 
	              if(!isset($this->kit4[$sender->getName()])){
	                 $this->kit4[$sender->getName()] = time() + $this->config->get("cooldown"); //[time second] [time hours] [time minute] cool down to caim the kit
	                 $sender->sendMessage($this->config->get("claim-message"));
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
                    
               case 0:
               $this->config = new Config($this->getPlugin()->kitFolder() . "/kit5.yml", Config::YAML);
	           $tools = Enchantment::getEnchantment($this->config->get("Swordenchant1"));
	           $armor = Enchantment::getEnchantment($this->config->get("Armorenchant1"));
	           $tools2 = Enchantment::getEnchantment($this->config->get("Swordenchant2"));
	           $armor2 = Enchantment::getEnchantment($this->config->get("Armorenchant2"));
               
               if(!$sender->hasPermission($this->config->get("perm"))){
                  $sender->sendMessage("§7(§c!§7) §cYou don't have permission to use this kit");
               }else{ 
	              if(!isset($this->kit5[$sender->getName()])){
	                 $this->kit5[$sender->getName()] = time() + $this->config->get("cooldown"); //[time second] [time hours] [time minute] cool down to caim the kit
	                 $sender->sendMessage($this->config->get("claim-message"));
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
        $form->setTitle("§l§a-=Kits§l=-");
	$form->setContent("§8You are given §2Slytherin§8 Kit by default. To get better kits you need to level up your wizardry\n\n§bYour level§8:§a $xp");
	if(!isset($this->getPlugin()->skit[$sender->getName()])){
	$form->addButton($sender->hasPermission("slytherin.use") === true ? "§8[§r§2Slytherin§8]§r\n§aUNLOCKED" : "§8[§r§2Slytherin§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->skit[$sender->getName()] >= 0) and ($sender->hasPermission("slytherin.kit"))){
	    $form->addButton("§8[§r§2Slytherin§8]§r\n§c ". (round(($this->getPlugin()->skit[$sender->getName()] - time()) / 60)). "Minutes");
	}
	if(!isset($this->getPlugin()->hpkit[$sender->getName()])){
	   $form->addButton($sender->hasPermission("harrypotter.kit") === true ? "§8[§fHarryPotter§r§8]§r\n§aUNLOCKED" : "§8[§fHarryPotter§r§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->hpkit[$sender->getName()] >= 0) and ($sender->hasPermission("harrypotter.kit"))){
	    $form->addButton("§8[§fHarryPotter§r§8]§r\n§c ". (round(($this->getPlugin()->hpkit[$sender->getName()] - time()) / 60)). "Minutes");
	}
	if(!isset($this->getPlugin()->dekit[$sender->getName()])){
	$form->addButton($sender->hasPermission("deatheater.kit") === true ? "§8[§k§c--§r§cDeathEater§r§k§c--§r§8]§r\n§aUNLOCKED" : "§8[§k§c--§r§cDeathEater§r§k§c--§r§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->dekit[$sender->getName()] >= 0) and ($sender->hasPermission("deatheater.kit"))){
	    $form->addButton("§8[§k§c--§r§cDeathEater§r§k§c--§r§8]§r\n§c ". (round(($this->getPlugin()->dekit[$sender->getName()] - time()) / 60)). "Minutes");
	}
	if(!isset($this->getPlugin()->voldkit[$sender->getName()])){
	$form->addButton($sender->hasPermission("voldemort.kit") === true ? "§8[§k§c--§r§4Voldemort§r§k§c--§r§8]§r\n§aUNLOCKED" : "§8[§k§c--§r§4Voldemort§r§k§c--§r§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->voldkit[$sender->getName()] >= 0) and ($sender->hasPermission("voldemort.kit"))){
	    $form->addButton("§8[§k§c--§r§4Voldemort§r§k§c--§r§8]§r\n§c ". (round(($this->getPlugin()->voldkit[$sender->getName()] - time()) / 60)). "Minutes");
	}
        $form->sendToPlayer($sender);
        return $form;
    }

    
    
           
        
        
      
