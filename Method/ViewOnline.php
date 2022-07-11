<?php
namespace GDO\OnlineUsers\Method;

use GDO\Table\MethodQueryList;
use GDO\User\GDO_User;
use GDO\Core\Application;
use GDO\OnlineUsers\Module_OnlineUsers;
use GDO\Date\Time;

/**
 * View recently active users.
 * 
 * @version 6.10.3
 * @since 6.7.0
 * @author gizmore
 */
final class ViewOnline extends MethodQueryList
{
    public function gdoTable() { return GDO_User::table(); }
    
    public function getDefaultOrder() { return 'user_last_activity DESC'; }
    
    public function getQuery()
    {
        $cut = Module_OnlineUsers::instance()->onlineDateCut();
        return GDO_User::table()->select()->
            where("user_last_activity >= '$cut'")->
            where('user_type IN ("member", "guest")');
    }
    
}
