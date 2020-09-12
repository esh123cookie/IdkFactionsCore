<?php

namespace esh123unicorn\factioncore\command\warp;

use esh123unicorn\factioncore\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\utils\config;

class Make extends PluginCommand{

    private $owner;
    
    private $config;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("make.use");
        $this->setDescription("Create your own warps");
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender->hasPermission("test.use")) {
            if (!isset($args[0])) {
                $sender->sendMessage("§7(§c!§7) §cUsage §7/§ctest §7{§cgolden§7/§cquaffle§7/§cbludger§7/§cdragon§7/§cremove§7}");
                return false;
            }
            if ($args[0]) {
                switch (strtolower($args[0])) {
                    case 'golden':
        		    $this->getPlugin()->spawnGolden($sender);
                        break;
                    case 'quaffle':
       	 		    $this->getPlugin()->spawnQuaffle($sender);
                        break;
                    case 'bludger':
        		    $this->getPlugin()->spawnBludger($sender);
                        break;
                    case 'dragon':
        		    $this->getPlugin()->spawnDragon($sender);
                        break;
                    case 'remove':
           	 	    $level = $sender->getLevel();
			    $levelname = $level->getFolderName();
		   	    foreach($level->getEntities() as $entity) {
				    if($entity instanceof Entity) {
                      		    $entity->close(); 
            	    		    $sender->sendMessage("§7(§c!§7) §cCleared all mobs in " . $levelname);
				    }
			     }
                        break;
		}
	    }
        } else {
            $sender->sendMessage("§7(§c!§7) §cYou do not have permission to use this command");
            return false;
        }
        return false;
    }
}
