<?php

namespace BayAlper10\MoneyBE;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Server;

use BayAlper10\MoneyBE\events\PlayerJoinEvent;

use BayAlper10\MoneyBE\commands\MyMoney;
use BayAlper10\MoneyBE\commands\SeeMoney;
use BayAlper10\MoneyBE\commands\SendMoney;
use BayAlper10\MoneyBE\commands\EditMoney;

use BayAlper10\MoneyBE\sqlite\MySQLProvider;

class Main extends PluginBase{

  private static $instance;
  public $money;

  public static function getInstance(): Main{
    return self::$instance;
  }

  public function onLoad(): void{
    self::$instance = $this;
    $this->komutKaydet();
  }

  public function onEnable(): void{
    $this->eventKaydet();
    $this->getLogger()->info("MoneyBE enabled");
    @mkdir($this->getDataFolder());
    $this->money = new Config($this->getDataFolder()."config.yml", Config::YAML);
  }

  public function eventKaydet(): void{
    $manager = $this->getServer()->getPluginManager();
    $manager->registerEvents(new PlayerJoinEvent(), $this);
  }

  public function komutKaydet(): void{
    $command = $this->getServer()->getCommandMap();
    $command->register("mymoney", new MyMoney($this));
    $command->register("seemoney", new SeeMoney($this));
    $command->register("sendmoney", new SendMoney($this));
    $command->register("editmoney", new EditMoney($this));
  }
}
