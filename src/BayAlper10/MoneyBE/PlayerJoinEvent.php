<?php

namespace BayAlper10\MoneyBE\events;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent as PlayerJoinEventPM;
use BayAlper10\MoneyBE\Main;
use BayAlper10\MoneyBE\economy\Economy;
use pocketmine\{Player, Server};

class PlayerJoinEvent implements Listener{

  public function PlayerJoinEventPM(PlayerJoinEventPM $event){
    $player = $event->getPlayer();
    $name = $player->getName();

    Economy::Create($player);
  }
}
