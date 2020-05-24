<?php

namespace xtakumatutix\mbb;

use pocketmine\plugin\PluginBase;

Class Main extends PluginBase 
{

    public function onEnable() 
    {
        $this->getLogger()->notice("起動メッセージを送信しました - ver.".$this->getDescription()->getVersion());
        $this->getServer()->getPluginManager()->registerEvents(new BossBarshow($this), $this);
    }
}