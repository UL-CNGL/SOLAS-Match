<?php
namespace SolasMatch\Common\Protobufs\Models;

// @@protoc_insertion_point(namespace:.SolasMatch.Common.Protobufs.Models.TaskReview)

/**
 * Generated by the protocol buffer compiler.  DO NOT EDIT!
 * source: TaskReview.proto
 *
 * -*- magic methods -*-
 *
 * @method string getProjectId()
 * @method void setProjectId(\string $value)
 * @method string getTaskId()
 * @method void setTaskId(\string $value)
 * @method string getUserId()
 * @method void setUserId(\string $value)
 * @method string getCorrections()
 * @method void setCorrections(\string $value)
 * @method string getGrammar()
 * @method void setGrammar(\string $value)
 * @method string getSpelling()
 * @method void setSpelling(\string $value)
 * @method string getConsistency()
 * @method void setConsistency(\string $value)
 * @method string getComment()
 * @method void setComment(\string $value)
 */
class TaskReview extends \ProtocolBuffers\Message
{
  // @@protoc_insertion_point(traits:.SolasMatch.Common.Protobufs.Models.TaskReview)
  
  /**
   * @var string $project_id
   * @tag 1
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT32
   **/
  protected $project_id;
  
  /**
   * @var string $task_id
   * @tag 2
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT32
   **/
  protected $task_id;
  
  /**
   * @var string $user_id
   * @tag 3
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT32
   **/
  protected $user_id;
  
  /**
   * @var string $corrections
   * @tag 4
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT32
   **/
  protected $corrections;
  
  /**
   * @var string $grammar
   * @tag 5
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT32
   **/
  protected $grammar;
  
  /**
   * @var string $spelling
   * @tag 6
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT32
   **/
  protected $spelling;
  
  /**
   * @var string $consistency
   * @tag 7
   * @label optional
   * @type \ProtocolBuffers::TYPE_INT32
   **/
  protected $consistency;
  
  /**
   * @var string $comment
   * @tag 8
   * @label optional
   * @type \ProtocolBuffers::TYPE_STRING
   **/
  protected $comment;
  
  
  // @@protoc_insertion_point(properties_scope:.SolasMatch.Common.Protobufs.Models.TaskReview)

  // @@protoc_insertion_point(class_scope:.SolasMatch.Common.Protobufs.Models.TaskReview)

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
        "name"     => "project_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(2, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT32,
        "name"     => "task_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(3, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT32,
        "name"     => "user_id",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(4, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT32,
        "name"     => "corrections",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(5, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT32,
        "name"     => "grammar",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(6, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT32,
        "name"     => "spelling",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(7, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_INT32,
        "name"     => "consistency",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => null,
      )));
      $desc->addField(8, new \ProtocolBuffers\FieldDescriptor(array(
        "type"     => \ProtocolBuffers::TYPE_STRING,
        "name"     => "comment",
        "required" => false,
        "optional" => true,
        "repeated" => false,
        "packable" => false,
        "default"  => "",
      )));
      // @@protoc_insertion_point(builder_scope:.SolasMatch.Common.Protobufs.Models.TaskReview)

      $descriptor = $desc->build();
    }
    return $descriptor;
  }

}
