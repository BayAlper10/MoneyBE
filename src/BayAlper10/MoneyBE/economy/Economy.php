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
}
