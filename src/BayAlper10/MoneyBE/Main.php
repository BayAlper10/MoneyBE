<?php

namespace BayAlper10\MoneyBE;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Server;
use pocketmine\Player;
use BayAlper10\MoneyBE\Main;

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

  public static function myMoney(Player $sender){
    $sender->sendMessage("Paran: §6" . (string)Main::getInstance()->money->get($sender->getName()));
  }

  public static function sendMoney(Player $sender, Player $target, int $amount){
    $sendername = $sender->getName();
    if((int)$this->money->get($sendername) >= $amount){
      $targetname = $target->getName();
      Main::getInstance()->set($targetname, (int)Main::getInstance()->get($targetname) +  int($amount));
      Main::getInstance()->money->set($sendername, (int)Main::getInstance()->money->get($sendername) - int($amount));
      Main::getInstance()->money->save();

      $sender->sendMessage($targetname . " adlı oyuncuya §7" . $amount . " §fpara gönderdin.");
      $target->sendMessage($sendername . " adlı oyuncu size §7" . $amount . " §fpara gönderdi.");
    }else{
      $sender->sendMessage("§cGöndermek istediğin miktarda para bulunamadı.");
    }
  }

  public static function editMoney(Player $sender, Player $target, int $amount){
    $sendername = $sender->getName();
    $targetname = $target->getName();

    Main::getInstance()->set($targetname, (int)$amount);
    Main::getInstance()->save();

    $sender->sendMessage($targetname . " adlı oyuncunun parası §7" . $amount . " §folarak ayarlandı.");
    $target->sendMessage("Bir yetkili paranızı §7" . $amount . " §folarak ayarladı.");
  }

  public static function seeMoney(Player $sender, Player $target){
    $targetname = $target->getName();
    $money = Main::getInstance()->get($targetname);
    $sender->sendMessage($targetname . " adlı oyuncunun parası §7" . (int)$money);
  }
}
