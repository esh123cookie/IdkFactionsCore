<?php

namespace esh123unicorn\factioncore\command\extra;

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

class Fly extends PluginCommand{

    private $owner;
    
    private $config;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("fly.use");
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
