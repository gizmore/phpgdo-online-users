<?php
namespace GDO\OnlineUsers;

use GDO\Core\GDO_Module;
use GDO\Core\GDT_Checkbox;
use GDO\Date\GDT_Duration;
use GDO\UI\GDT_Page;
use GDO\Core\Application;
use GDO\Date\Time;

/**
 * User online statistics.
 * Display currently online in View.
 * 
 * @author gizmore
 * @version 6.10.3
 * @since 3.0.1
 */
final class Module_OnlineUsers extends GDO_Module
{
	##############
	### Config ###
	##############
    public function getConfig() : array
    {
        return [
        	GDT_Duration::make('online_timeout')->initial('300'),
            GDT_Checkbox::make('show_in_top_bar')->initial('1'),
        ];
    }
    public function cfgOnlineTime() { return $this->getConfigValue('online_timeout'); }
    public function cfgShowInTopBar() { return $this->getConfigValue('show_in_top_bar'); }
    
    public function onlineTimeoutCut() { return Application::$TIME - $this->cfgOnlineTime(); }
    public function onlineDateCut() { return Time::getDate($this->onlineTimeoutCut()); }
    
    ############
    ### Init ###
    ############
    public function onLoadLanguage() : void { $this->loadLanguage('lang/onlineusers'); }
    
    #############
    ### Hooks ###
    #############
    public function onInitSidebar() : void
    {
        if ($this->cfgShowInTopBar())
        {
            GDT_Page::$INSTANCE->topNav->addField(
                GDT_OnlineUsers::make());
        }
    }
    
}
