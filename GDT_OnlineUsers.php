<?php
namespace GDO\OnlineUsers;

use GDO\DB\Cache;
use GDO\OnlineUsers\Method\ViewOnline;
use GDO\Session\GDO_Session;
use GDO\UI\GDT_Link;

/**
 * This GDT displays how many users are online at the moment.
 *
 * @version 6.10.3
 * @since 6.4.0
 * @author gizmore
 */
final class GDT_OnlineUsers extends GDT_Link
{

	protected function __construct()
	{
		parent::__construct();
		$this->href(href('OnlineUsers', 'ViewOnline'));
	}

	public static function getOnlineUsers()
	{
		static $cache;
		if ($cache === null)
		{
			$key = 'gdt_onlineusers';
			if (null === ($cache = Cache::get($key)))
			{
				$cache = self::countOnline();
				Cache::set($key, $cache, 10);
			}
		}
		return $cache;
	}

	public static function countOnline()
	{
		static $online = null;
		if ($online === null)
		{
			$online = ViewOnline::make()->getQuery()->
			selectOnly('COUNT(*)')->first()->
			exec()->fetchVar();

			if (GDO_Session::isDB())
			{
				$cut = Module_OnlineUsers::instance()->onlineDateCut();
				$online += GDO_Session::table()->
				countWhere("sess_user IS NULL AND sess_time > '$cut'");
			}
		}
		return $online;
	}

	public function renderHTML(): string
	{
		$this->label('list_onlineusers_viewonline', [
			$this->countOnline()]);
		return parent::renderHTML();
	}

}
