<?php

namespace BayAlper10\MoneyBE\sqlite;

use BayAlper10\MoneyBE\Main;

class MySQLProvider implements Provider{

  private $plugin;

  public function __construct(Main $plugin){
    $this->plugin = $plugin;
  }

  public function open(){
    // COMING SOON
  }
}
