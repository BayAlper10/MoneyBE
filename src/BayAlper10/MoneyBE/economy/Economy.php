<?php

namespace BayAlper10\MoneyBE\economy;

use BayAlper10\MoneyBE\Main;
use pocketmine\{Player, Server};

class Economy{

  private $plugin;

  public function __construct(Main $plugin){
    $this->plugin = $plugin;
  }

  public static function Create(Player $sender){
    if(Main::getInstance()->money->get($sender->getName()) == null){
      Main::getInstance()->money->set($sender->getName(), 0);
      Main::getInstance()->money->save();
    }else{
      return;
    }
  }

  public static function myMoney(Player $sender){
    $sender->sendMessage("Paran: §6" . (string)Main::getInstance()->money->get($sender->getName()));
  }

  public static function sendMoney(Player $sender, Player $target, int $amount){
    $sendername = $sender->getName();
    if((int)Main::getInstance()->money->get($sendername) >= $amount){
      $targetname = $target->getName();
      Main::getInstance()->money->set($targetname, (int)Main::getInstance()->money->get($targetname) +  int($amount));
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

    Main::getInstance()->money->set($targetname, (int)$amount);
    Main::getInstance()->money->save();

    $sender->sendMessage($targetname . " adlı oyuncunun parası §7" . $amount . " §folarak ayarlandı.");
    $target->sendMessage("Bir yetkili paranızı §7" . $amount . " §folarak ayarladı.");
  }

  public static function seeMoney(Player $sender, Player $target){
    $targetname = $target->getName();
    $money = Main::getInstance()->money->get($targetname);
    $sender->sendMessage($targetname . " adlı oyuncunun parası §7" . (int)$money);
  }
}
