<?php

require_once __DIR__.'/../Common/Settings.class.php';
require_once __DIR__.'/../Common/lib/PDOWrapper.class.php';

class UnitTestHelper
{
    private function __constuct() {}
    
    public static function teardownDb()
    {
        $dsn = "mysql:host=".Settings::get('unit_test.server').";dbname=".Settings::get('unit_test.database').
                ";port=".Settings::get('unit_test.port');
        $dsn1 = "mysql:host=".Settings::get('database.server').";dbname=".Settings::get('database.database').
                ";port=".Settings::get('database.server_port');
        assert($dsn1 != $dsn);
        
        PDOWrapper::$unitTesting = true;
        $conn = new PDO($dsn,
                        Settings::get('unit_test.username'), Settings::get('unit_test.password'),
                        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));         
        unset($dsn);
        unset($dsn1);
        $tables = $conn->query("SELECT t.TABLE_NAME FROM information_schema.`TABLES` t WHERE t.TABLE_SCHEMA='Unit-Test'
                                AND t.TABLE_NAME NOT IN('Languages','Countries', 'TaskTypes', 'TaskStatus')");
        
        foreach($tables as $table) $conn->query("DELETE FROM $table[0]");
        
        $conn->query("REPLACE INTO `Badges` (`id`, `owner_id`, `title`, `description`) VALUES
                    (3, NULL, 'Profile-Filler', 'Filled in required info for user profile.'),
                    (4, NULL, 'Registered', 'Successfully set up an account'),
                    (5, NULL, 'Native-Language', 'Filled in your native language on your user profile.');");
    }
    
    
   
    // Create system badge by default
    public function createBadge($id = NULL, $title = "System Badge 1", $description = "System Badge 1 Description", $ownerId = NULL)
    {       
        $newBadge = new Badge();      
        $newBadge->setId($id);
        $newBadge->setTitle($title);
        $newBadge->setDescription($description);
        $newBadge->setOwnerId($ownerId);       
        return $newBadge;
    }
    
    public function createOrg($id = NULL, $name = "Organisation 1", $biography = "Organisation Biography 1", $homepage = "http://www.organisation1.org")
    {
        $org = new Organisation();
        $org->setId($id);
        $org->setName($name);
        $org->setBiography($biography);
        $org->setHomePage($homepage);        
        return $org;
    }
    
    // password = hash("sha512", "abcdefghikjlmnop")
    public function createUser($userId = NULL, $displayName = "User 1", $biography = "User 1 Bio", $email = "user1@test.com", $nonce = "123456789"
            , $password = "2d5e2eb5e2d5b1358161c8418e2fd3f46a431452a724257907d4a3317677a99414463452507ef607941e14044363aab9669578ce5f9517cb36c9acb32f492393"
            , $nativeLangId = null, $nativeRegionId = null, $createdTime = null)
    {
        $user = new User();
        $user->setUserId($userId);
        $user->setDisplayName($displayName);   
        $user->setBiography($biography);
        $user->setEmail($email);
        $user->setNonce($nonce);
        $user->setPassword($password);
        $user->setNativeLangId($nativeLangId);
        $user->setNativeRegionId($nativeRegionId);
        $user->setCreatedTime($createdTime);    
        return $user;
    }
    
    
}

?>
