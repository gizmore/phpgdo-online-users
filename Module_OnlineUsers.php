<?php
namespace GDO\OnlineUsers;

use GDO\Core\Application;
use GDO\Core\GDO_Module;
use GDO\Core\GDT_Checkbox;
use GDO\Date\GDT_Duration;
use GDO\Date\Time;
use GDO\UI\GDT_Page;

/**
 * User online statistics.
 * Display currently online in View.
 *
 * @version 7.0.1
 * @since 3.0.1
 * @author gizmore
 */
final class Module_OnlineUsers extends GDO_Module
{

	##############
	### Config ###
	##############
	public function getConfig(): array
	{
		return [
			GDT_Duration::make('online_timeout')->initial('10m'),
			GDT_Checkbox::make('hook_sidebar')->initial('1'),
		];
	}

	public function onLoadLanguage(): void { $this->loadLanguage('lang/onlineusers'); }

	public function onInitSidebar(): void
	{
		if ($this->cfgShowInTopBar())
		{
			GDT_Page::instance()->topBar()->addField(
				GDT_OnlineUsers::make());
		}
	}

	public function cfgShowInTopBar() { return $this->getConfigValue('hook_sidebar'); }

	public function onlineDateCut() { return Time::getDate($this->onlineTimeoutCut()); }

	############
	### Init ###
	############

	public function onlineTimeoutCut() { return Application::$TIME - $this->cfgOnlineTime(); }

	#############
	### Hooks ###
	#############

	public function cfgOnlineTime() { return $this->getConfigValue('online_timeout'); }

}
