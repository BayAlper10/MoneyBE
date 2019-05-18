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

class SendMoney extends Command implements PluginIdentifiableCommand{

	public $plugin;

	public function __construct(Main $plugin){
		$this->plugin = $plugin;
		parent::__construct("sendmoney", "Send money to another player");
		$this->setUsage("/sendmoney playername amount");
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
			if(count($args) < 2){
				$sender->sendMessage("§8» §c/sendmoney playername amount");
			}else{
				$target = $sender->getServer()->getPlayer($args[0]);
				if($target instanceof Player){
					$miktar = (int)$args[1];
					if(is_numeric($miktar)){
						if($miktar != 0){
							if($miktar > 0){
								Economy::SendMoney($sender, $target, $miktar);
							}else{
								$sender->sendMessage("§cNegatif rakam giremezsiniz!");
							}
						}else{
							$sender->sendMessage("§cLütfen 0'dan büyük bir rakam belirleyiniz!");
						}
					}else{
						$sender->sendMessage("§8» §cLütfen sayısal bir değer giriniz!");
					}
				}else{
					$sender->sendMessage("§8» §cBelirtilen oyuncu bulunamadı!");
				}
			}
			return true;
		}
	}
}
