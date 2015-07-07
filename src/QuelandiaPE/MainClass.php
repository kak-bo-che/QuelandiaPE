<?php

namespace QuelandiaPE;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\Player;
use pocketmine\block\Block as Block;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class MainClass extends PluginBase implements Listener{

	public function onLoad(){
		$this->getLogger()->info(TextFormat::WHITE . "I've been loaded!");
	}

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info(TextFormat::DARK_GREEN . "I've been enabled!");
    }

	public function onDisable(){
		$this->getLogger()->info(TextFormat::DARK_RED . "I've been disabled!");
	}

	function stealItem($thief_name, $victim_name){
		$item_name = function($item){
			return $item->getName();
		};

		$thief = Server::getInstance()->getPlayer($thief_name);
		$victim = Server::getInstance()->getPlayer($victim_name);
		if ($thief and $victim){
			$items = $victim->getInventory()->getContents();
			$item_keys = array_keys($items);
			if (!empty($items)){
				$item_index = $item_keys[rand(0, count($items) - 1)];
				$stolen_item = $victim->getInventory()->getItem($item_index);
				$item_name = $stolen_item->getName();
				$thief->getInventory()->addItem($stolen_item);
				$victim->getInventory()->removeItem($stolen_item);
				$thief->sendMessage("You have stolen {$item_name} from {$victim_name}");
				$victim->sendMessage("{$thief_name} just stole your {$item_name}");
				return true;
			}
		}
		return false;
	}

	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		switch($command->getName()){
			case "steal_item":
			 	$thief_name = array_shift($args);
			 	$victim_name = array_shift($args);
			 	$this->stealItem($thief_name, $victim_name);
				return true;
			case "create_base":
				return true;
			default:
				return false;
		}
	}

	/**
	 * @param PlayerRespawnEvent $event
	 *
	 * @priority        NORMAL
	 * @ignoreCancelled false
	 */
	public function onSpawn(PlayerRespawnEvent $event){
		Server::getInstance()->broadcastMessage($event->getPlayer()->getDisplayName() . " has just spawned!");
	}
}
