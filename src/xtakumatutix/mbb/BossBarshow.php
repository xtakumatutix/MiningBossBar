<?php

// アイコン:http://flat-icon-design.com/?p=453

namespace xtakumatutix\mbb;

use bossbarapi\bossbar\BossBar;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\Plugin;
use pocketmine\scheduler\ClosureTask;
use pocketmine\Server;
use Deceitya\MiningLevel\MiningLevelAPI;

class BossBarshow implements Listener 
{
    private $Main;

    public function __construct(Main $Main)
    {
        $this->Main = $Main;
    }

    public function onJoin(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        $task = new ClosureTask(function (int $currentTick) use ($player): void {
            $exp = MiningLevelAPI::getInstance()->getExp($player);
            $level = MiningLevelAPI::getInstance()->getLevel($player);
            $next = MiningLevelAPI::getInstance()->getLevelUpExp($player);
            $bossBar = BossBar::create($player);
            $bossBar->setTitle("現在のレベル：".$level);
            $bossBar->setPercentage($exp / $next);
            $bossBar->show();
        });
        $plugin = Server::getInstance()->getPluginManager()->getPlugin("MiningBossBar");
        /** @var Plugin $plugin */
        $plugin->getScheduler()->scheduleRepeatingTask($task, 20);
    }
}