<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Badges
 *
 * @author sean
 */

require_once '../app/BadgeDao.class.php';
class Badges {
    public static function init(){
        Dispatcher::registerNamed(HttpMethodEnum::GET, '/v0/badges(:format)/', function ($format=".json"){
            $dao = new BadgeDao();
           Dispatcher::sendResponce(null, $dao->getAllBadges(), null, $format);
        },'getBadges');
        
        Dispatcher::registerNamed(HttpMethodEnum::GET, '/v0/badges/:id/', function ($id,$format=".json"){
           if(!is_numeric($id)&& strstr($id, '.')){
               $id= explode('.', $id);
               $format='.'.$id[1];
               $id=$id[0];
           }
           $dao = new BadgeDao();
           Dispatcher::sendResponce(null, $dao->find(array('badge_id'=>$id)), null, $format);
        },'getBadge');
        
        Dispatcher::registerNamed(HttpMethodEnum::GET, '/v0/badges/:id/users(:format)', function ($id,$format=".json"){
           $dao = new UserDao();
           Dispatcher::sendResponce(null, $dao->getUsersWithBadgeByID($id), null, $format);
        },'getusersWithBadge');
        
    }
}
Badges::init();
?>