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
use pocketmine\math\Vector3;

class Warp extends PluginCommand{

    private $owner;
    
    private $config;
    
    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("warp.use");
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
            if($sender->hasPermission("warp.use")) {
               $this->openWarpUI($sender);   
            } else {
               $sender->sendMessage("§7(§c!§7) §cYou do not have permission to use this command");
            }
    }
               
                
    public function openWarpUI(CommandSender $sender)
    {
        $this->config = new Config($this->getPlugin()->getDataFolder() . "/warps.yml", Config::YAML);
        if(!($sender instanceof Player)){
                return true;
            }
            $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            }
            switch ($data) {
            	case 0: 
        	$cords = new Config($this->getPlugin()->getDataFolder() . "/cords.yml", Config::YAML);
	        $x = $cords->get("warp1x");
	        $y = $cords->get("warp1y");
	        $z = $cords->get("warp1z");
	        $world1 = $cords->get("warp1level");
	        if($world1 == null) {
	           $sender->sendMessage("§7(§c!§7) §cSpawn has not been set yet");
	        }else{
     	       $world = $this->getPlugin()->getServer()->getLevelByName($world1);
     	       $sender->teleport($world->getSafeSpawn());
               $sender->teleport(new Vector3($x, $y, $z, 0, 0));
               $sender->sendMessage("§7(§a!§7) §aYou are being warped to spawn..."); 
               }
               break;
               case 1: 
        	$cords = new Config($this->getPlugin()->getDataFolder() . "/cords.yml", Config::YAML);
	        $x = $cords->get("warp2x");
	        $y = $cords->get("warp2y");
	        $z = $cords->get("warp2z");
	        $world1 = $cords->get("warp2level");
	        if($world1 == null) {
	           $sender->sendMessage("§7(§c!§7) §cBosses has not been set yet");
	        }else{
     	       $world = $this->getPlugin()->getServer()->getLevelByName($world1);
     	       $sender->teleport($world->getSafeSpawn());
               $sender->teleport(new Vector3($x, $y, $z, 0, 0));
               $sender->sendMessage("§7(§a!§7) §aYou are being warped to bosses..."); 
               }
               break;  
               case 2: 
        	$cords = new Config($this->getPlugin()->getDataFolder() . "/cords.yml", Config::YAML);
	        $x = $cords->get("warp3x");
	        $y = $cords->get("warp3y");
	        $z = $cords->get("warp3z");
	        $world1 = $cords->get("warp3level");
	        if($world1 == null) {
	           $sender->sendMessage("§7(§c!§7) §cPvP has not been set yet");
	        }else{
     	       $world = $this->getPlugin()->getServer()->getLevelByName($world1);
     	       $sender->teleport($world->getSafeSpawn());
               $sender->teleport(new Vector3($x, $y, $z, 0, 0));
               $sender->sendMessage("§7(§a!§7) §aYou are being warped to pvp..."); 
               }
               break;
               case 3:
               //exit
               break;
            }
        });
        $form->setTitle($this->config->get("title"));
	$form->setContent($this->config->get("content"));
        $form->addButton($this->config->get("button1"));
        $form->addButton($this->config->get("button2"));
        $form->addButton($this->config->get("button3"));
        $form->addButton($this->config->get("exit-button"));
        $form->sendToPlayer($sender);
    }
}
