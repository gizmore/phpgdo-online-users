<?php
namespace GDO\OnlineUsers\Method;

use GDO\Table\MethodQueryList;
use GDO\User\GDO_User;
use GDO\Core\GDO;
use GDO\DB\Query;
use GDO\OnlineUsers\Module_OnlineUsers;

/**
 * View recently active users.
 * 
 * @version 7.0.1
 * @since 6.7.0
 * @author gizmore
 */
final class ViewOnline extends MethodQueryList
{
    public function gdoTable() : GDO { return GDO_User::table(); }
    
    public function getDefaultOrder() : ?string { return 'user_last_activity DESC'; }
    
    public function getQuery() : Query
    {
        $cut = Module_OnlineUsers::instance()->onlineDateCut();
        return GDO_User::table()->select()->
            where("user_last_activity >= '$cut'")->
            where('user_type IN ("member", "guest")');
    }
    
}
