<?php

class Cities_Manager
{

	public function Cities_Manager() {
	}

	public function getRecommendedCitiesFor($id) {

		// SELECT c.city_id, c.city_name, c.rating
		// FROM cities c
		// INNER JOIN cities_ratings r ON c.city_id = r.city_id
		// WHERE r.account_id
		// IN (

		// SELECT a.account_id
		// FROM accounts AS a
		// INNER JOIN accounts_connections AS c ON c.friend_id = a.account_id
		// WHERE c.account_id =8
		// )
		// AND r.city_id NOT
		// IN (

		// SELECT cr.city_id
		// FROM cities_ratings cr
		// WHERE account_id =8
		// )
		// GROUP BY c.city_id
		// ORDER BY c.rating DESC

		$db = Zend_Registry::get('dbAdapter');

		if (!is_numeric($id)) {
			throw new SocialException(SocialException::USER_NOT_SPECIFIED);
			return false;
		}

		$friendsSelect = $db->select()
		             ->from(array('a' => 'accounts'), array('a.account_id'))
		             ->joinInner(array('c' => 'accounts_connections'),'c.friend_id = a.account_id',array());
		$friendsSelect->where('c.account_id = ?', $id);

		$citiesVisitedSelect = $db->select()
		             ->from(array('cr' => 'cities_ratings'), array('cr.city_id'));
		$citiesVisitedSelect->where('cr.account_id = ?', $id);

		$citiesFields = array(
			"city_id" 		=> "c.city_id",
			"city_name" 	=> "c.city_name",
			"rating" 		=> "c.rating"
		);

		$db = Zend_Registry::get('dbAdapter');
		$select = $db->select()
		             ->from(array('c' => 'cities'), $citiesFields)
		             ->joinInner(array('r' => 'cities_ratings'),'c.city_id = r.city_id',array());
		$select->where('r.account_id in ?', new Zend_Db_Expr('(' . $friendsSelect . ')'));
		$select->where('r.city_id not in ?', new Zend_Db_Expr('(' . $citiesVisitedSelect . ')'));
		$select->group('c.city_id');
		$select->order(array('c.rating DESC'));
		$result = $db->fetchAll($select);

		return $result;

	}

}