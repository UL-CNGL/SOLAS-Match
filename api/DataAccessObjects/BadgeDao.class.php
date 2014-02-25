<?php

//! The Badge Data Access Object for the API
/*!
  A class for setting and retrieving Badge related data from the database.
  Used by the API Route Handlers to supply info requested through the API and perform actions.
  All data is retrieved an input with direct access to the database using stored procedures.
*/
require_once __DIR__."/../../Common/models/Badge.php";
require_once __DIR__."/../../api/lib/PDOWrapper.class.php";

class BadgeDao
{
    //! Used to retieve Badge data from the database
    /*!
      Used to retrieve Badge data from the database. The parameters can be used to filter the list of badges that will
      be returned. If all the parameters are passed as null then all system badges are returned.
      @param int $badgeId is the id of the Badge being requested or null for any
      @param string $title is the title/name of the Badge being requested or null for any
      @param string $description is the description of the Badge being requested or null for any
      @param int $ownerId is the id of the Organisation the Badge is associated with or null for system badges
      @return Returns a list of Badge objects or null if no Badge objects matching the parameters are found
    */
    public static function getBadge($badgeId = null, $title = null, $description = null, $ownerId = null)
    {
        $args = PDOWrapper::cleanseNull($badgeId)
                .",".PDOWrapper::cleanseNullOrWrapStr($title)
                .",".PDOWrapper::cleanseNullOrWrapStr($description)
                .",".PDOWrapper::cleanseNull($ownerId);
        
        if ($result = PDOWrapper::call("getBadge", $args)) {
            $badges = array();
            foreach ($result as $badge) {
                $badges[] = ModelFactory::buildModel("Badge", $badge);
            }
            return $badges;
        }
        return null;
    }
    
    //! Used to insert or update a Badge
    /*!
      Takes a Badge object and inserts/updates it in the database. If the Badge object passed has a valid id then it
      will update that badge on the Database. If no Badge id is supplied then a new Badge will be created.
      @param Badge $badge is the Badge object that must be inserted or updated
      @return Returns the updated/inserted Badge object. If it was inserted the returned object will have an id.
    */
    public static function insertAndUpdateBadge($badge)
    {
        $args = PDOWrapper::cleanseNullOrWrapStr($badge->getId())
                .",".PDOWrapper::cleanseNull($badge->getOwnerId())
                .",".PDOWrapper::cleanseNullOrWrapStr($badge->getTitle())
                .",".PDOWrapper::cleanseNullOrWrapStr($badge->getDescription());
        
        if ($result = PDOWrapper::call("badgeInsertAndUpdate", $args)) {
            return ModelFactory::buildModel("Badge", $result[0]);
        } else {
            return null;
        }
    }

    //! Get Badge objects associated with the specified Organisation
    /*!
      Gets all the Badge objects that were created by the specified Organisation.
      @param int $orgId is the id of the Organisation that owns the Badge objects.
      @return Returns a list of Badge objects
    */
    public static function getOrgBadges($orgId)
    {
        $ret = null;
        $args = "null,null,null,".PDOWrapper::cleanseNull($orgId);
        if ($badge_array = PDOWrapper::call("getBadge", $args)) {
            $ret = array();
            foreach ($badge_array as $badge) {
                $ret[] = ModelFactory::buildModel("Badge", $badge);
            }
        }
        return $ret;
    }

    //! Used to assign a Badge to a User
    /*!
      @note This function sends an email request to the backend for UserBadgeAwardedEmail
      @param int $userId is the id of the User
      @param int $badgeId is the id of the Badge being assigned
      @return Returns 1 on success, 0 on failure
    */
    public static function assignBadge($userId, $badgeId)
    {
        $args = PDOWrapper::cleanseNull($userId)
                .",".PDOWrapper::cleanseNull($badgeId);
        if (!$validation = self::validateUserBadge($userId, $badgeId)) {
            Notify::sendUserAssignedBadgeEmail($userId, $badgeId);
            if ($result = PDOWrapper::call("assignBadge", $args)) {
                return $result[0]["result"];
            }
        }
        
        return 0;
    }
    
    //! Removes a Badge from a User
    /*!
      @param int $userId is the id of the User
      @param int $badgeId is the id of the Badge being removed
      @return Returns 1 on successful removal, 0 otherwise
    */
    public static function removeUserBadge($userId, $badgeId)
    {
        $args = PDOWrapper::cleanseNull($userId)
                .",".PDOWrapper::cleanseNull($badgeId);
        $result = PDOWrapper::call("removeUserBadge", $args);
        return $result[0]["result"];
    }
    
    //! Permanently delete a Badge
    /*!
      Permanently delete a Badge from the system.
      @param int $badgeId is id the of the Badge being deleted
      @return Returns 1 if successfully deleted, 0 otherwise
    */
    public static function deleteBadge($badgeId)
    {
        $args = PDOWrapper::cleanseNull($badgeId);
        if ($result = PDOWrapper::call("deleteBadge", $args)) {
            return $result[0]["result"];
        }
        return 0;
    }
    
    //! Determine if a User has a Badge
    /*!
      @param int $userId is the id of the User being validated
      @param int $badgeId is the id of the Badge being validated
      @return Returns 1 if the User has the Badge, 0 otherwise
    */
    public static function validateUserBadge($userId, $badgeId)
    {
        $args = PDOWrapper::cleanseNull($userId)
                .",".PDOWrapper::cleanseNull($badgeId);
        $result = PDOWrapper::call("userHasBadge", $args);
        return $result[0]['result'];
    }
}
