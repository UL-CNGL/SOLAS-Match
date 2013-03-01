<?php
// DO NOT EDIT! Generated by Protobuf-PHP protoc plugin 0.9.4
// Source: ProjectFile.proto
//   Date: 2013-03-01 15:08:21

namespace  {

  class ProjectFile extends \DrSlump\Protobuf\Message {

    /**  @var int */
    public $projectId = null;
    
    /**  @var string */
    public $filename = null;
    
    /**  @var string */
    public $token = null;
    
    /**  @var int */
    public $userId = null;
    

    /** @var \Closure[] */
    protected static $__extensions = array();

    public static function descriptor()
    {
      $descriptor = new \DrSlump\Protobuf\Descriptor(__CLASS__, '.ProjectFile');

      // OPTIONAL INT32 projectId = 1
      $f = new \DrSlump\Protobuf\Field();
      $f->number    = 1;
      $f->name      = "projectId";
      $f->type      = \DrSlump\Protobuf::TYPE_INT32;
      $f->rule      = \DrSlump\Protobuf::RULE_OPTIONAL;
      $descriptor->addField($f);

      // OPTIONAL STRING filename = 2
      $f = new \DrSlump\Protobuf\Field();
      $f->number    = 2;
      $f->name      = "filename";
      $f->type      = \DrSlump\Protobuf::TYPE_STRING;
      $f->rule      = \DrSlump\Protobuf::RULE_OPTIONAL;
      $descriptor->addField($f);

      // OPTIONAL STRING token = 3
      $f = new \DrSlump\Protobuf\Field();
      $f->number    = 3;
      $f->name      = "token";
      $f->type      = \DrSlump\Protobuf::TYPE_STRING;
      $f->rule      = \DrSlump\Protobuf::RULE_OPTIONAL;
      $descriptor->addField($f);

      // OPTIONAL INT32 userId = 4
      $f = new \DrSlump\Protobuf\Field();
      $f->number    = 4;
      $f->name      = "userId";
      $f->type      = \DrSlump\Protobuf::TYPE_INT32;
      $f->rule      = \DrSlump\Protobuf::RULE_OPTIONAL;
      $descriptor->addField($f);

      foreach (self::$__extensions as $cb) {
        $descriptor->addField($cb(), true);
      }

      return $descriptor;
    }

    /**
     * Check if <projectId> has a value
     *
     * @return boolean
     */
    public function hasProjectId(){
      return $this->_has(1);
    }
    
    /**
     * Clear <projectId> value
     *
     * @return \ProjectFile
     */
    public function clearProjectId(){
      return $this->_clear(1);
    }
    
    /**
     * Get <projectId> value
     *
     * @return int
     */
    public function getProjectId(){
      return $this->_get(1);
    }
    
    /**
     * Set <projectId> value
     *
     * @param int $value
     * @return \ProjectFile
     */
    public function setProjectId( $value){
      return $this->_set(1, $value);
    }
    
    /**
     * Check if <filename> has a value
     *
     * @return boolean
     */
    public function hasFilename(){
      return $this->_has(2);
    }
    
    /**
     * Clear <filename> value
     *
     * @return \ProjectFile
     */
    public function clearFilename(){
      return $this->_clear(2);
    }
    
    /**
     * Get <filename> value
     *
     * @return string
     */
    public function getFilename(){
      return $this->_get(2);
    }
    
    /**
     * Set <filename> value
     *
     * @param string $value
     * @return \ProjectFile
     */
    public function setFilename( $value){
      return $this->_set(2, $value);
    }
    
    /**
     * Check if <token> has a value
     *
     * @return boolean
     */
    public function hasToken(){
      return $this->_has(3);
    }
    
    /**
     * Clear <token> value
     *
     * @return \ProjectFile
     */
    public function clearToken(){
      return $this->_clear(3);
    }
    
    /**
     * Get <token> value
     *
     * @return string
     */
    public function getToken(){
      return $this->_get(3);
    }
    
    /**
     * Set <token> value
     *
     * @param string $value
     * @return \ProjectFile
     */
    public function setToken( $value){
      return $this->_set(3, $value);
    }
    
    /**
     * Check if <userId> has a value
     *
     * @return boolean
     */
    public function hasUserId(){
      return $this->_has(4);
    }
    
    /**
     * Clear <userId> value
     *
     * @return \ProjectFile
     */
    public function clearUserId(){
      return $this->_clear(4);
    }
    
    /**
     * Get <userId> value
     *
     * @return int
     */
    public function getUserId(){
      return $this->_get(4);
    }
    
    /**
     * Set <userId> value
     *
     * @param int $value
     * @return \ProjectFile
     */
    public function setUserId( $value){
      return $this->_set(4, $value);
    }
  }
}
