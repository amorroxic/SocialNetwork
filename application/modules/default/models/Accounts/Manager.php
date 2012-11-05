<?php

class Accounts_Manager
{

	public $table;

	public function Accounts_Manager() {
		$this->table = new Accounts_Table();
	}

	public function getAccounts() {
		$select = $this->table->select();
		$rows = $this->table->fetchAll($select);
		$rows = $rows->toArray();
		return $rows;
	}

	public function getIdForSlug($slug)	{

		if (!isset($slug)) {
			throw new SocialException(SocialException::USER_NOT_SPECIFIED);
			return false;
		}

		if (get_magic_quotes_gpc()) {
			$slug = mysql_real_escape_string(stripslashes($slug));
		} else {
			$slug = mysql_real_escape_string($slug);
		}

		$select = $this->table->select();
		$select->where('slug = ?',$slug);
		$rows = $this->table->fetchAll($select);
		$rows = $rows->toArray();

		if (count($rows) == 0) {
			throw new SocialException(SocialException::USER_NOT_FOUND);
			return -1;
		}

		return $rows[0]['account_id'];
	}

	public function getFriendsOf($id) {

		// SELECT a.first_name, a.last_name, a.gender, a.age, a.slug
		// FROM accounts AS a
		// INNER JOIN accounts_connections AS c ON c.friend_id = a.account_id
		// WHERE c.account_id =5

		if (!is_numeric($id)) {
			throw new SocialException(SocialException::USER_NOT_SPECIFIED);
			return false;
		}

		$accountFields = array(
			"first_name" 	=> "a.first_name",
			"last_name" 	=> "a.last_name",
			"gender" 		=> "a.gender",
			"age" 			=> "a.age",
			"slug" 			=> "a.slug",
		);

		$db = Zend_Registry::get('dbAdapter');
		$select = $db->select()
		             ->from(array('a' => 'accounts'), $accountFields)
		             ->joinInner(array('c' => 'accounts_connections'),'c.friend_id = a.account_id',array());
		$select->where('c.account_id = ?', $id);
		$result = $db->fetchAll($select);

		return $result;

	}

	public function getFriendsOfFriendsOf($id) {

		if (!is_numeric($id)) {
			throw new SocialException(SocialException::USER_NOT_SPECIFIED);
			return false;
		}

		// SELECT a.account_id, a.first_name, a.last_name, a.gender, a.age, a.slug
		// FROM accounts_connections c, accounts a
		// WHERE a.account_id = c.account_id
		// AND c.friend_id
		// IN (
		// 	SELECT aa.account_id
		// 	FROM accounts_connections cc, accounts aa
		// 	WHERE aa.account_id = cc.account_id
		// 	AND cc.friend_id =5
		// )
		// AND a.account_id NOT
		// IN (
		// 	SELECT a.account_id
		// 	FROM accounts_connections c, accounts a
		// 	WHERE a.account_id = c.account_id
		// 	AND c.friend_id =5
		// )
		// GROUP BY a.account_id

		// -- same query with inner joins

		// SELECT a.account_id, a.first_name, a.last_name, a.gender, a.age, a.slug
		// FROM accounts a
		// INNER JOIN accounts_connections c ON a.account_id = c.account_id
		// WHERE c.friend_id IN
		// (
		// 	-- friends of friends
		// 	SELECT a.account_id
		// 	FROM accounts a
		// 	INNER JOIN accounts_connections c ON a.account_id = c.account_id
		// 	WHERE c.friend_id =5
		// )
		// AND a.account_id NOT IN
		// (
		// 	-- ignore users being directly connected with the subject
		// 	SELECT a.account_id
		// 	FROM accounts a
		// 	inner join accounts_connections c ON a.account_id = c.account_id
		// 	WHERE c.friend_id =5
		// )
		// GROUP BY a.account_id

		$db = Zend_Registry::get('dbAdapter');

		$friendsSelect = $db->select()
		             ->from(array('a' => 'accounts'), array('a.account_id'))
		             ->joinInner(array('c' => 'accounts_connections'),'a.account_id = c.account_id',array());
		$friendsSelect->where('c.friend_id = ?', $id);

		$friendsOfFriendsFields = array(
			"first_name" 	=> "a.first_name",
			"last_name" 	=> "a.last_name",
			"gender" 		=> "a.gender",
			"age" 			=> "a.age",
			"slug" 			=> "a.slug"
		);

		$select = $db->select()
		             ->from(array('a' => 'accounts'), $friendsOfFriendsFields)
		             ->joinInner(array('c' => 'accounts_connections'),'a.account_id = c.account_id',array());
		$select->where('c.friend_id in ?', new Zend_Db_Expr('(' . $friendsSelect . ')'));
		$select->where('a.account_id not in ?', new Zend_Db_Expr('(' . $friendsSelect . ')'));
		$select->where('a.account_id <> ?', $id);
		$select->group(array('a.account_id'));

		$result = $db->fetchAll($select);

		return $result;

	}

	public function getSuggestedFriendsFor($id) {

		if (!is_numeric($id)) {
			throw new SocialException(SocialException::USER_NOT_SPECIFIED);
			return false;
		}

		// SELECT first_name, last_name, gender, age, slug, common_friends
		// FROM (
		// 	SELECT a.account_id, a.first_name, a.last_name, a.gender, a.age, a.slug, count( a.account_id ) AS common_friends
		// 	FROM accounts a
		// 	INNER JOIN accounts_connections c ON a.account_id = c.account_id
		// 	WHERE c.friend_id IN
		// 	(
		// 		-- get friends of friends
		// 		SELECT a.account_id
		// 		FROM accounts a
		// 		INNER JOIN accounts_connections c ON a.account_id = c.account_id
		// 		WHERE c.friend_id =5
		// 	)
		// 	AND a.account_id NOT IN
		// 	(
		// 		-- ignore users being directly connected with the subject
		// 		SELECT a.account_id
		// 		FROM accounts a
		// 		inner join accounts_connections c ON a.account_id = c.account_id
		// 		WHERE c.friend_id =5
		// 	)
		// 	GROUP BY a.account_id
		// ) AS a
		// WHERE a.common_friends > 1 AND a.account_id <> 5


		$db = Zend_Registry::get('dbAdapter');

		$friendsSelect = $db->select()
		             ->from(array('a' => 'accounts'), array('a.account_id'))
		             ->joinInner(array('c' => 'accounts_connections'),'a.account_id = c.account_id',array());
		$friendsSelect->where('c.friend_id = ?', $id);

		$friendsOfFriendsFields = array(
			"account_id" 		=> "a.account_id",
			"first_name" 		=> "a.first_name",
			"last_name" 		=> "a.last_name",
			"gender" 			=> "a.gender",
			"age" 				=> "a.age",
			"slug" 				=> "a.slug",
			'common_friends'	=> "count(a.account_id)"
		);

		$friendsOfFriendsSelect = $db->select()
		             ->from(array('a' => 'accounts'), $friendsOfFriendsFields)
		             ->joinInner(array('c' => 'accounts_connections'),'a.account_id = c.account_id',array());
		$friendsOfFriendsSelect->where('c.friend_id in ?', new Zend_Db_Expr('(' . $friendsSelect . ')'));
		$friendsOfFriendsSelect->where('a.account_id not in ?', new Zend_Db_Expr('(' . $friendsSelect . ')'));
		$friendsOfFriendsSelect->group(array('a.account_id'));

		$suggestedFriendsFields = array(
			'first_name',
			'last_name',
			'gender',
			'age',
			'slug',
			'common_friends'
		);

		$suggestedFriendsSelect = $db->select()
		             ->from(array('a' => new Zend_Db_Expr('(' . $friendsOfFriendsSelect . ')')), $suggestedFriendsFields);
		$suggestedFriendsSelect->where('a.common_friends > 1');
		$suggestedFriendsSelect->where('a.account_id <> ?', $id);

		$result = $db->fetchAll($suggestedFriendsSelect);

		return $result;

	}

}