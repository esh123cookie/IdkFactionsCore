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

class LevelUp extends PluginCommand{

    private $owner;
    
    private $config;
    
    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("levelup.use");
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
            if($sender->hasPermission("levelup.use")) {
               $this->onLevelUp($sender);   
            } else {
               $sender->sendMessage("§7(§c!§7) §cYou do not have permission to use this command");
            }
    }
    
    public function onLevelUp(Player $player) { 
        $this->config = new Config($this->getPlugin()->getDataFolder() . "/levelup.yml", Config::YAML);
        $level = $this->getPlugin()->getLevel($player);
        $nextLevel = $this->getPlugin()->getNextLevel($player);
	if($nextLevel >= $this->config->get("levels")) {
	   $player->sendMessage($this->config->get("max-level-message"));
	}else{
	   if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($player) >= ($level * $this->config->get("economy-multiplier"))){
           $this->getPlugin()->getServer()->broadcastMessage($this->config->get("levelup-message") . " " . $nextLevel);
           $playerConfig = new Config($this->getPlugin()->playerFolder . ucfirst($player->getName()) . ".yml", Config::YAML);
           $playerConfig->set("level", $level + 1);
           $playerConfig->save();
	   if($this->config->get("player-command") == true) {
              $this->getPlugin()->getServer()->dispatchCommand($player, $this->config->get("command1"));
              $this->getPlugin()->getServer()->dispatchCommand($player, $this->config->get("command2"));
	   }else{
              $this->getPlugin()->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $this->config->get("command1"));
              $this->getPlugin()->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $this->config->get("command2"));
	   }
        }else{
           $player->sendMessage($this->config->get("not-enough-money-message"));
	   }
        }
    }
}
           
