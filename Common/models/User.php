<?php
// DO NOT EDIT! Generated by Protobuf-PHP protoc plugin 0.9.4
// Source: User.proto
//   Date: 2012-11-28 13:39:34

namespace  {

  class User extends \DrSlump\Protobuf\Message {

    /**  @var int */
    public $user_id = null;
    
    /**  @var string */
    public $display_name = null;
    
    /**  @var string */
    public $email = null;
    
    /**  @var string */
    public $password = null;
    
    /**  @var string */
    public $biography = null;
    
    /**  @var string */
    public $nonce = null;
    
    /**  @var string */
    public $created_time = null;
    
    /**  @var int */
    public $native_lang_id = null;
    
    /**  @var int */
    public $native_region_id = null;
    

    /** @var \Closure[] */
    protected static $__extensions = array();

    public static function descriptor()
    {
      $descriptor = new \DrSlump\Protobuf\Descriptor(__CLASS__, '.User');

      // REQUIRED INT32 user_id = 1
      $f = new \DrSlump\Protobuf\Field();
      $f->number    = 1;
      $f->name      = "user_id";
      $f->type      = \DrSlump\Protobuf::TYPE_INT32;
      $f->rule      = \DrSlump\Protobuf::RULE_REQUIRED;
      $descriptor->addField($f);

      // OPTIONAL STRING display_name = 2
      $f = new \DrSlump\Protobuf\Field();
      $f->number    = 2;
      $f->name      = "display_name";
      $f->type      = \DrSlump\Protobuf::TYPE_STRING;
      $f->rule      = \DrSlump\Protobuf::RULE_OPTIONAL;
      $descriptor->addField($f);

      // OPTIONAL STRING email = 3
      $f = new \DrSlump\Protobuf\Field();
      $f->number    = 3;
      $f->name      = "email";
      $f->type      = \DrSlump\Protobuf::TYPE_STRING;
      $f->rule      = \DrSlump\Protobuf::RULE_OPTIONAL;
      $descriptor->addField($f);

      // OPTIONAL STRING password = 4
      $f = new \DrSlump\Protobuf\Field();
      $f->number    = 4;
      $f->name      = "password";
      $f->type      = \DrSlump\Protobuf::TYPE_STRING;
      $f->rule      = \DrSlump\Protobuf::RULE_OPTIONAL;
      $descriptor->addField($f);

      // OPTIONAL STRING biography = 5
      $f = new \DrSlump\Protobuf\Field();
      $f->number    = 5;
      $f->name      = "biography";
      $f->type      = \DrSlump\Protobuf::TYPE_STRING;
      $f->rule      = \DrSlump\Protobuf::RULE_OPTIONAL;
      $descriptor->addField($f);

      // OPTIONAL STRING nonce = 6
      $f = new \DrSlump\Protobuf\Field();
      $f->number    = 6;
      $f->name      = "nonce";
      $f->type      = \DrSlump\Protobuf::TYPE_STRING;
      $f->rule      = \DrSlump\Protobuf::RULE_OPTIONAL;
      $descriptor->addField($f);

      // OPTIONAL STRING created_time = 7
      $f = new \DrSlump\Protobuf\Field();
      $f->number    = 7;
      $f->name      = "created_time";
      $f->type      = \DrSlump\Protobuf::TYPE_STRING;
      $f->rule      = \DrSlump\Protobuf::RULE_OPTIONAL;
      $descriptor->addField($f);

      // OPTIONAL INT32 native_lang_id = 8
      $f = new \DrSlump\Protobuf\Field();
      $f->number    = 8;
      $f->name      = "native_lang_id";
      $f->type      = \DrSlump\Protobuf::TYPE_INT32;
      $f->rule      = \DrSlump\Protobuf::RULE_OPTIONAL;
      $descriptor->addField($f);

      // OPTIONAL INT32 native_region_id = 9
      $f = new \DrSlump\Protobuf\Field();
      $f->number    = 9;
      $f->name      = "native_region_id";
      $f->type      = \DrSlump\Protobuf::TYPE_INT32;
      $f->rule      = \DrSlump\Protobuf::RULE_OPTIONAL;
      $descriptor->addField($f);

      foreach (self::$__extensions as $cb) {
        $descriptor->addField($cb(), true);
      }

      return $descriptor;
    }

    /**
     * Check if <user_id> has a value
     *
     * @return boolean
     */
    public function hasUserId(){
      return $this->_has(1);
    }
    
    /**
     * Clear <user_id> value
     *
     * @return \User
     */
    public function clearUserId(){
      return $this->_clear(1);
    }
    
    /**
     * Get <user_id> value
     *
     * @return int
     */
    public function getUserId(){
      return $this->_get(1);
    }
    
    /**
     * Set <user_id> value
     *
     * @param int $value
     * @return \User
     */
    public function setUserId( $value){
      return $this->_set(1, $value);
    }
    
    /**
     * Check if <display_name> has a value
     *
     * @return boolean
     */
    public function hasDisplayName(){
      return $this->_has(2);
    }
    
    /**
     * Clear <display_name> value
     *
     * @return \User
     */
    public function clearDisplayName(){
      return $this->_clear(2);
    }
    
    /**
     * Get <display_name> value
     *
     * @return string
     */
    public function getDisplayName(){
      return $this->_get(2);
    }
    
    /**
     * Set <display_name> value
     *
     * @param string $value
     * @return \User
     */
    public function setDisplayName( $value){
      return $this->_set(2, $value);
    }
    
    /**
     * Check if <email> has a value
     *
     * @return boolean
     */
    public function hasEmail(){
      return $this->_has(3);
    }
    
    /**
     * Clear <email> value
     *
     * @return \User
     */
    public function clearEmail(){
      return $this->_clear(3);
    }
    
    /**
     * Get <email> value
     *
     * @return string
     */
    public function getEmail(){
      return $this->_get(3);
    }
    
    /**
     * Set <email> value
     *
     * @param string $value
     * @return \User
     */
    public function setEmail( $value){
      return $this->_set(3, $value);
    }
    
    /**
     * Check if <password> has a value
     *
     * @return boolean
     */
    public function hasPassword(){
      return $this->_has(4);
    }
    
    /**
     * Clear <password> value
     *
     * @return \User
     */
    public function clearPassword(){
      return $this->_clear(4);
    }
    
    /**
     * Get <password> value
     *
     * @return string
     */
    public function getPassword(){
      return $this->_get(4);
    }
    
    /**
     * Set <password> value
     *
     * @param string $value
     * @return \User
     */
    public function setPassword( $value){
      return $this->_set(4, $value);
    }
    
    /**
     * Check if <biography> has a value
     *
     * @return boolean
     */
    public function hasBiography(){
      return $this->_has(5);
    }
    
    /**
     * Clear <biography> value
     *
     * @return \User
     */
    public function clearBiography(){
      return $this->_clear(5);
    }
    
    /**
     * Get <biography> value
     *
     * @return string
     */
    public function getBiography(){
      return $this->_get(5);
    }
    
    /**
     * Set <biography> value
     *
     * @param string $value
     * @return \User
     */
    public function setBiography( $value){
      return $this->_set(5, $value);
    }
    
    /**
     * Check if <nonce> has a value
     *
     * @return boolean
     */
    public function hasNonce(){
      return $this->_has(6);
    }
    
    /**
     * Clear <nonce> value
     *
     * @return \User
     */
    public function clearNonce(){
      return $this->_clear(6);
    }
    
    /**
     * Get <nonce> value
     *
     * @return string
     */
    public function getNonce(){
      return $this->_get(6);
    }
    
    /**
     * Set <nonce> value
     *
     * @param string $value
     * @return \User
     */
    public function setNonce( $value){
      return $this->_set(6, $value);
    }
    
    /**
     * Check if <created_time> has a value
     *
     * @return boolean
     */
    public function hasCreatedTime(){
      return $this->_has(7);
    }
    
    /**
     * Clear <created_time> value
     *
     * @return \User
     */
    public function clearCreatedTime(){
      return $this->_clear(7);
    }
    
    /**
     * Get <created_time> value
     *
     * @return string
     */
    public function getCreatedTime(){
      return $this->_get(7);
    }
    
    /**
     * Set <created_time> value
     *
     * @param string $value
     * @return \User
     */
    public function setCreatedTime( $value){
      return $this->_set(7, $value);
    }
    
    /**
     * Check if <native_lang_id> has a value
     *
     * @return boolean
     */
    public function hasNativeLangId(){
      return $this->_has(8);
    }
    
    /**
     * Clear <native_lang_id> value
     *
     * @return \User
     */
    public function clearNativeLangId(){
      return $this->_clear(8);
    }
    
    /**
     * Get <native_lang_id> value
     *
     * @return int
     */
    public function getNativeLangId(){
      return $this->_get(8);
    }
    
    /**
     * Set <native_lang_id> value
     *
     * @param int $value
     * @return \User
     */
    public function setNativeLangId( $value){
      return $this->_set(8, $value);
    }
    
    /**
     * Check if <native_region_id> has a value
     *
     * @return boolean
     */
    public function hasNativeRegionId(){
      return $this->_has(9);
    }
    
    /**
     * Clear <native_region_id> value
     *
     * @return \User
     */
    public function clearNativeRegionId(){
      return $this->_clear(9);
    }
    
    /**
     * Get <native_region_id> value
     *
     * @return int
     */
    public function getNativeRegionId(){
      return $this->_get(9);
    }
    
    /**
     * Set <native_region_id> value
     *
     * @param int $value
     * @return \User
     */
    public function setNativeRegionId( $value){
      return $this->_set(9, $value);
    }
  }
}
