<?php

namespace BayAlper10\MoneyBE\commands;

use BayAlper10\MoneyBE\Main;
use BayAlper10\MoneyBE\economy\Economy;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;

class MyMoney extends Command implements PluginIdentifiableCommand{

	public $plugin;

	public function __construct(Main $plugin){
		$this->plugin = $plugin;
		parent::__construct("mymoney", "Look at your money");
		$this->setUsage("/mymoney");
	}

	public function getPlugin(): Plugin{
		return $this->plugin;
	}

	public function execute(CommandSender $sender, string $label, array $args): bool{
		if($this->plugin->isEnabled()){
			if($sender instanceof ConsoleCommandSender){
				$sender->sendMessage('§cBu komut, konsoldan kullanılamaz');
				return true;
			}
			Economy::MyMoney($sender);
			return true;
		}
	}
}
