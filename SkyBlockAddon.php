<?php
declare(strict_types = 1);

/**
 * @name SkyBlockAddon
 * @version 1.0.0
 * @main   JackMD\ScoreHud\Addons\SkyBlockAddon
 * @depend SkyBlock
 */
namespace JackMD\ScoreHud\Addons
{

	use JackMD\ScoreHud\addon\AddonBase;
	use pocketmine\Player;
	use room17\SkyBlock\session\BaseSession as SkyBlockSession;
	use room17\SkyBlock\SkyBlock;

	class SkyBlockAddon extends AddonBase{

		/** @var SkyBlock */
		private $skyBlock;

		public function onEnable(): void{
			$this->skyBlock = $this->getServer()->getPluginManager()->getPlugin("SkyBlock");
		}

		/**
		 * @param Player $player
		 * @return array
		 */
		public function getProcessedTags(Player $player): array{
			return [
				"{is_state}"   => $this->getIslandState($player),
				"{is_blocks}"  => $this->getIslandBlocks($player),
				"{is_members}" => $this->getIslandMembers($player),
				"{is_size}"    => $this->getIslandSize($player),
				"{is_rank}"    => $this->getIslandRank($player)
			];
		}

		/**
		 * @param Player $player
		 * @return string
		 */
		public function getIslandState(Player $player){
			$session = $this->skyBlock->getSessionManager()->getSession($player);

			if((is_null($session)) || (!$session->hasIsland())){
				return "No Island";
			}

			$isle = $session->getIsland();

			return $isle->isLocked() ? "Locked" : "Unlocked";
		}

		/**
		 * @param Player $player
		 * @return int|string
		 */
		public function getIslandBlocks(Player $player){
			$session = $this->skyBlock->getSessionManager()->getSession($player);

			if((is_null($session)) || (!$session->hasIsland())){
				return "No Island";
			}

			$isle = $session->getIsland();

			return $isle->getBlocksBuilt();
		}

		/**
		 * @param Player $player
		 * @return int|string
		 */
		public function getIslandMembers(Player $player){
			$session = $this->skyBlock->getSessionManager()->getSession($player);

			if((is_null($session)) || (!$session->hasIsland())){
				return "No Island";
			}

			$isle = $session->getIsland();

			return count($isle->getMembers());
		}

		/**
		 * @param Player $player
		 * @return string
		 */
		public function getIslandSize(Player $player){
			$session = $this->skyBlock->getSessionManager()->getSession($player);

			if((is_null($session)) || (!$session->hasIsland())){
				return "No Island";
			}

			$isle = $session->getIsland();

			return $isle->getCategory();
		}

		/**
		 * @param Player $player
		 * @return string
		 */
		public function getIslandRank(Player $player){
			$session = $this->skyBlock->getSessionManager()->getSession($player);

			if((is_null($session)) || (!$session->hasIsland())){
				return "No Island";
			}

			switch($session->getRank()){
				case SkyBlockSession::RANK_DEFAULT:
					return "Member";
				case SkyBlockSession::RANK_OFFICER:
					return "Officer";
				case SkyBlockSession::RANK_LEADER:
					return "Leader";
				case SkyBlockSession::RANK_FOUNDER:
					return "Founder";
			}

			return "No Rank";
		}
	}
}
