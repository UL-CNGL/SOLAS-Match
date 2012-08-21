<?php

require('models/Badge.class.php');
require('BadgeValidator.class.php');

class BadgeDao
{
    public function find($params)
    {
        $db = new PDOWrapper();
        $db->init();
        $result=$db->call("getBadge", "{$db->cleanse($params['badge_id'])},null,null");
        return new Badge($result[0]);
    }

    public function save($badge)
    {
        $db = new MySQLWrapper();
        $db->init();
        $insert = array();
        $insert['owner_id'] = $badge->getOwnerId();
        $insert['title'] = "\"".$badge->getTitle()."\"";
        $insert['description'] = "\"".$badge->getDescription()."\"";
        $db->Insert('badges', $insert);
    }

    public function getAllBadges()
    {
        $db = new PDOWrapper();
        $db->init();
        $result=$db->call("getBadge", "null,null,null,null");
        return $result;
    }

    public function getOrgBadges($org_id)
    {
        $db = new PDOWrapper();
        $db->init();
        return $db->call("getBadge", "null,null,null,{$db->cleanse($org_id)}");
    }

    public function assignBadge($user, $badge)
    {
        $badgeValidator = new BadgeValidator();
        if($badgeValidator->validateUserBadge($user, $badge)) {
            $db = new PDOWrapper();
            $db->init();
            $db->call("assignBadge", "{$db->cleanse($user->getUserId())},{$db->cleanse($badge->getBadgeId())}");
        }
    }

    public function removeUserBadge($user, $badge)
    {
        if(!is_null($badge->getOwnerId())) {
            $db = new MySQLWrapper();
            $db->init();
            $delete = "DELETE FROM user_badges
                        WHERE user_id=".$db->cleanse($user->getUserId())."
                        AND badge_id=".$db->cleanse($badge->getBadgeId());
            $db->Delete($delete);
        } else {
            echo "<p>Cannot remove system badges</p>";
        }
    }
}
