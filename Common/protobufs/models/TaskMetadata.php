<?php
namespace SolasMatch\Common\Protobufs\Models;

// @@protoc_insertion_point(namespace:.SolasMatch.Common.Protobufs.Models.TaskMetadata)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: TaskMetadata.proto
 *
 * -*- magic methods -*-
 *
 * @method string getId()
 * @method void setId(\string $value)
 * @method string getVersion()
 * @method void setVersion(\string $value)
 * @method string getFilename()
 * @method void setFilename(\string $value)
 * @method string getContentType()
 * @method void setContentType(\string $value)
 * @method string getUserId()
 * @method void setUserId(\string $value)
 * @method string getUploadTime()
 * @method void setUploadTime(\string $value)
 */
class TaskMetadata extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.SolasMatch.Common.Protobufs.Models.TaskMetadata)
  
  /**
   * @var string $id
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT32
   **/
  protected $id;
  
  /**
   * @var string $version
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT32
   **/
  protected $version;
  
  /**
   * @var string $filename
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $filename;
  
  /**
   * @var string $content_type
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $content_type;
  
  /**
   * @var string $user_id
   * @tag 5
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT32
   **/
  protected $user_id;
  
  /**
   * @var string $upload_time
   * @tag 6
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $upload_time;
  
  
  // @@protoc_insertion_point(properties_scope:.SolasMatch.Common.Protobufs.Models.TaskMetadata)

  // @@protoc_insertion_point(class_scope:.SolasMatch.Common.Protobufs.Models.TaskMetadata)

  /**
   * get descriptor for protocol buffers
   * 
   * @return \ProtocolBuffersDescriptor
   */
  public static function getDescriptor()
  {
    static $descriptor;
    
    if (!isset($descriptor)) {
      $desc = new \ProtocolBuffers\DescriptorBuilder();
      $desc->addField(1, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT32,
        "name"     => "id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT32,
        "name"     => "version",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "filename",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "content_type",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      $desc->addField(5, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT32,
        "name"     => "user_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(6, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "upload_time",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      // @@protoc_insertion_point(builder_scope:.SolasMatch.Common.Protobufs.Models.TaskMetadata)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
