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

class LevelUp extends PluginCommand{

    private $owner;
    
    private $config;
    
    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("spawn.use");
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
            if($sender->hasPermission("spawn.use")) {
               $this->openSpawn($sender);   
            } else {
               $sender->sendMessage("§7(§c!§7) §cYou do not have permission to use this command");
            }
    }
