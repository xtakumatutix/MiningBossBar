<?php

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
        $bossBar = BossBar::create($player);
        $task = new ClosureTask(function (int $currentTick) use ($player, $bossBar): void {
            $exp = MiningLevelAPI::getInstance()->getExp($player);
            $level = MiningLevelAPI::getInstance()->getLevel($player);
            $next = MiningLevelAPI::getInstance()->getLevelUpExp($player);
            $math = $exp / $next;//計算
            $bossBar->setTitle("§b現在のレベル§f".$level."\n\n§b次のレベルまで§f".$exp."/".$next);//タイトル
            $bossBar->setPercentage($math);//ボスバーのあの残量みたいなやつ
            $bossBar->show();//表示
        });
        $plugin = Server::getInstance()->getPluginManager()->getPlugin("MiningBossBar");//Taskのやつね
        /** @var Plugin $plugin */
        $plugin->getScheduler()->scheduleRepeatingTask($task, 20);//一秒更新
    }
}