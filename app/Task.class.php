<?php

/*
	One job (such as a document) will be broken into one or more tasks.
	A task simply represents something that needs to get done in the system.
	An example of a task is to translate a segment, or an entire document.
*/
class Task {
	var $_task_id;
	var $_title;
	var $_organisation_id;
	var $_source_id;
	var $_target_id;
	var $_created_time;
	var $_word_count;
	var $_tags; // array of strings

	function __construct($params = NULL) {
		if (is_array($params)) {
			foreach ($params as $key => $value) {
				$this->_setParam($key, $value);
			}	
		}
	}

	function getTaskId() {
		return $this->_task_id;
	}

	function setTaskId($task_id) {
		$this->_task_id = $task_id;
	}

	public function setTitle($title) {
		$this->_title = $title;
	}

	public function getTitle() {
		return $this->_title;
	}

	public function setOrganisationId($organisation_id) {
		$this->_organisation_id = $organisation_id;
	}

	public function getOrganisationId() {
		return $this->_organisation_id;
	}

	public function setSourceId($source_id)
	{
		$this->_source_id = $source_id;
	}

	public function getSourceId() {
		return $this->_source_id;
	}

	public function setTargetId($target_id)
	{
		$this->_target_id = $target_id;
	}

	public function getTargetId() {
		return $this->_target_id;
	}

	public function setWordCount($word_count)
	{
		$this->_word_count = $word_count;
	}

	public function getWordCount() {
		return $this->_word_count;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	private function _setParam($key, $value)
	{
		$key_methods = array(
			'task_id' 			=> 'setTaskId',
			'title' 			=> 'setTitle',
			'organisation_id' 	=> 'setOrganisationId',
			'source_id'			=> 'setSourceId',
			'target_id'			=> 'setTargetId',
			'word_count'		=> 'setWordCount',
			'created_time'		=> 'setCreatedTime',
			'tags'				=> 'setTags'
		);

		if (isset($key_methods[$key])) {
			$this->$key_methods[$key]($value);	
		}
		else {
			throw new InvalidArgumentException('No function to set ' . $key);
		}
	}

	public function setCreatedTime($created_time) {
		$this->_created_time = $created_time;
	}
	
	public function getCreatedTime() {
		return $this->_created_time;
	}
	
	public function areSourceAndTargetSet() {
		return ($this->getSourceId() && $this->getTargetId());
	}

	public function setTags($tags) {
		if (!is_null($tags) && is_array($tags)) {
			$this->_tags = $tags;
		}
	}

	public function getTags() {
		return $this->_tags;
	}

	/**
	 * Old non-DAO code --------------------------------------------------------------------------
	 */

	function old_isInit()
	{
		return ( isset($this->id) && (intval($this->id)>0) );
	}
	
	/*
		Return a short title for the task, suitable for display as a quick identifying summary.
		Retuns an empty string if nothing found.
	*/
	function old_title()
	{
		$ret = '';
		$db = new MySQLWrapper();
		$db->init();
		$q = 'SELECT title
				FROM task
				WHERE id = '.$db->cleanse($this->id);
		if ($r = $db->Select($q))
		{
			$text = $r[0]['title'];
			$ret = $text;
		}
		return $ret;
	}
	
	/*
	 * Return the unix time stamp of when this task was created.
	 */
	function old_createdTime()
	{
		$ret = '';
		$db = new MySQLWrapper();
		$db->init();
		$q = 'SELECT created_time
				FROM task
				WHERE id = '.$db->cleanse($this->id);
		if ($r = $db->Select($q))
		{
			$ret = strtotime($r[0]['created_time']); // Converting to unix time string 
		}
		return $ret;
	}

	function old_createdTimeAgo() {
		return IO::timeSince($this->createdTime());
	}
	
	function old_wordcount()
	{
		$ret = false;
		$db = new MySQLWrapper();
		$db->init();
		$q = 'SELECT word_count
				FROM task
				WHERE id = '.$db->cleanse($this->id).'
				AND word_count IS NOT NULL';
		if ($r = $db->Select($q))
		{
			$ret = $r[0]['word_count'];
		}
		return $ret;
	}
	
	function old_target_id()
	{
		$ret = false;
		$db = new MySQLWrapper();
		$db->init();
		$q = 'SELECT target_id
				FROM task
				WHERE id = '.$db->cleanse($this->id).'
				AND target_id IS NOT NULL';
		if ($r = $db->Select($q))
		{
			$ret = $r[0][0];
		}
		return $ret;
	}
	
	function old_source_id()
	{
		$ret = false;
		$db = new MySQLWrapper();
		$db->init();
		$q = 'SELECT source_id
				FROM task
				WHERE id = '.$db->cleanse($this->id).'
				AND source_id IS NOT NULL';
		if ($r = $db->Select($q))
		{
			$ret = $r[0][0];
		}
		return $ret;
	}
	
	/*
	 * Return the natural language name of the target language.
	 */
	function old_target()
	{
		$ret = false;
		if ($target_id = $this->target_id())
		{
			$tags = new Tags();
			$ret = $tags->langName($target_id);
		}
		return $ret;
	}
	
	function old_source()
	{
		$ret = false;
		if ($source_id = $this->source_id())
		{
			$tags = new Tags();
			$ret = $tags->langName($source_id);
		}
		return $ret;
	}
	
	function old_organisationID()
	{
		$ret = false;
		$db = new MySQLWrapper();
		$db->init();
		$q = 'SELECT organisation_id
				FROM task
				WHERE id ='.$db->cleanse($this->id);
		if ($r = $db->Select($q))
		{
			$ret = $r[0]['organisation_id'];
		}
		return $ret;		
	}
	
	/*
		Return the string of the organisation's name who owns this task.
	*/
	function old_organisation()
	{
		$orgs = new Organisations();
		return $orgs->name($this->organisationID());
	}
	
	function old_url()
	{
		$url = new URL();
		return $url->server().'/task/'.$this->id.'/';
	}

	function old_tagIDs()
	{
		$tags = new Tags();
		return $tags->taskTagIDs($this->id);
	}

	function old_taskID()
	{
		return $this->id;		
	}
}
