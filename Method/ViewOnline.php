<?php
namespace GDO\OnlineUsers\Method;

use GDO\Table\MethodQueryList;
use GDO\User\GDO_User;
use GDO\Core\GDO;
use GDO\DB\Query;
use GDO\OnlineUsers\Module_OnlineUsers;
use GDO\User\GDO_UserSetting;

/**
 * View recently active users.
 * 
 * @version 7.0.2
 * @since 6.7.0
 * @author gizmore
 */
final class ViewOnline extends MethodQueryList
{
    public function gdoTable() : GDO { return GDO_User::table(); }
    
    public function getDefaultOrder() : ?string { return 'last_activity DESC'; }
    
    public function getExtraFieldNames(): array
    {
    	return ['last_activity'];
    }
    
    public function getQuery() : Query
    {
        $cut = Module_OnlineUsers::instance()->onlineDateCut();
        return GDO_UserSetting::usersWithQuery('User', 'last_activity', $cut, '>');
    }
    
}
