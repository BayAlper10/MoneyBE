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

class SeeMoney extends Command implements PluginIdentifiableCommand{

	public $plugin;

	public function __construct(Main $plugin){
		$this->plugin = $plugin;
		parent::__construct("seemoney", "Lets you look at a player's money");
		$this->setUsage("/seemoney playername");
	}

	public function getPlugin(): Plugin{
		return $this->plugin;
	}

	public function execute(CommandSender $sender, string $label, array $args): bool{
		if($this->plugin->isEnabled()){
			if($sender instanceof ConsoleCommandSender){
				$sender->sendMessage('§cBu komutu konsoldan kullanılamaz');
				return true;
			}
			if(count($args) < 1){
				$sender->sendMessage("§8» §c/seemoney playername");
			}else{
				$target = $sender->getServer()->getPlayer($args[0]);
				if($target instanceof Player){
					Main::SeeMoney($sender, $target);
				}else{
					$sender->sendMessage("§8» §cBelirtilen oyuncu bulunamadı!");
				}
			}
			return true;
		}
	}
}
