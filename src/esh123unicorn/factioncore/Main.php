<?php

namespace esh123unicorn\factioncore;

//core commands
use esh123unicorn\factioncore\command\Kit;
use esh123unicorn\factioncore\command\warp\Warp;
use esh123unicorn\factioncore\command\warp\Make;
use esh123unicorn\factioncore\command\warp\Spawn;
use esh123unicorn\factioncore\command\LevelUp;
use esh123unicorn\factioncore\command\Shop;

//core events
use esh123unicorn\factioncore\event\EventListener;
use esh123unicorn\factioncore\event\StoreData;

//config
use pocketmine\utils\config;

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

//pocketmine entities
use pocketmine\entity\Entity;
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

class Main extends PluginBase implements Listener {
  
    /** @var ProviderInterface */
    private $provider;
	
    /** @var null  */
    private static $instance = null;
  
    public $server;
	
    public $data;
  
    public $playerFolder;
	  
    public $kitFolder;
	
    public $player;
	
    public $level;
	
    public $faction;
  
    public function onEnable()
    {
        self::$instance = $this;
        if(!file_exists($this->playerFolder)) {
           $this->playerFolder = $this->getDataFolder() . "Players/";
           @mkdir($this->playerFolder, 0777, true);
	}
        if(!file_exists($this->kitFolder)) {
           $this->kitFolder = $this->getDataFolder() . "Kits/";
           @mkdir($this->kitFolder, 0777, true);
	}
        //var
        $this->server = Main::getInstance()->getServer();
	$this->data = StoreData::getInstance()->getServer();
      
        //events
        $this->server->getPluginManager()->registerEvents($this, $this);
        $this->server->getPluginManager()->registerEvents(new EventListener($this), $this); //done
        $this->server->getPluginManager()->registerEvents(new StoreData($this), $this); //done
	    
        $commandMap = $this->server->getCommandMap();
        $commandMap->register("fcore", new Kit("kits", $this));
        $commandMap->register("fcore", new Warp("warps", $this));
        $commandMap->register("fcore", new Make("make", $this));
        $commandMap->register("fcore", new Spawn("spawn", $this));
        $commandMap->register("fcore", new Shop("shop", $this));
        $commandMap->register("fcore", new LevelUp("levelup", $this));
	
	    
	$this->data->storeConfig();
	$this->data->storeKitsItems();
	$this->data->storeKitsUI();
	$this->data->storeCoordinates();
	$this->data->storeWarpsUI();
	$this->data->storeLevelUpInfo();
	$this->data->storeShopUI();
	$this->data->storeShopPrices();
	$this->data->storeShopNames();
    }
	
    public function getAPI()
    {
        return $this->server->getPluginManager()->getPlugin("FactionsPro");
    }
	
    /**
    * @param Player $player
    * @return bool
    */
    public function getFaction(Player $player): string{ 
	$this->faction = $this->getAPI()->getFaction($player->getName());
	return $this->faction;
    }				     
	
    /**
    * @param Player $player
    * @return bool
    */
    public function playerExists(Player $player): bool{
		$config = new Config($this->playerFolder . ucfirst($player->getName()) . ".yml", Config::YAML);
		return ($config->exists("level")) ? true : false;
    }
	
    /**
    * @param Player $player
    */
    public function registerPlayer(Player $player): void{
		$config = new Config($this->playerFolder . ucfirst($player->getName()) . ".yml", Config::YAML);
		if(!$config->exists("level")){
			$config->setAll([
				"player" => $player->getName(), 
				"ip" => $player->getAddress(), 
				"level" => null
			]);
			$config->save();
		}
    }
  
    /**
    * @param Player $player
    * @return string
    */
    public function getLevel(Player $player): int{
		$config = new Config($this->playerFolder . ucfirst($player->getName()) . ".yml", Config::YAML);
	    	$this->level = (int) $config->get("level");
		return $this->level;
    }
	
    /**
    * @param Player $player
    * @return string
    */
    public function getPerviousLevel(Player $player): int{
		return (int) $this->getLevel($player) - 1;
    }
	
    /**
    * @param Player $player
    * @return string
    */
    public function getNextLevel(Player $player): int{
		return (int) $this->getLevel($player) + 1;
    }
  
    public function getPlayers(): int{
	foreach($this->getServer()->getOnlinePlayers() as $this->player) {
	return (int) $this->player;
	}
    }
  
    /**
    * @return static
    */
    public static function getInstance() : self {
        return self::$instance;
    }
}

