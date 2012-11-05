<?php

class Import_Manager
{

	private $rawData;
	public $people;
	public $cities;
	private $view;

	// loads the contents of the file
	public function Import_Manager($view) {
		$this->view = $view;
		if (file_exists(ROOTDIR . '/configuration/socialGraph.php')) {
			$this->rawData = @include(ROOTDIR . '/configuration/socialGraph.php');
		} else {
			throw new SocialException(SocialException::IMPORTER_DATASET_ABSENT);
		}
	}

	// generate slugs, filter people having no names, validate age and gender
	public function sanitizeInputData() {

		// final curated array of people
		$output = array();

		// array of slugs, used to prevent different people getting the same slug
		$slugs = array();

		// array grouping cities by name
		$this->cities = array();

		if (!is_array($this->rawData)) {
			throw new SocialException(SocialException::IMPORTER_CHECK_ERROR);
			return false;
		}

		foreach ($this->rawData as $person) {

			// compose the full name
			$name = $person['firstName'] . ' ' . $person['surname'];

			// generate the slug (helps hiding the db id's, also good for SEO)
			$slug = $this->view->slug($name);

			// stop and skip the current user. He/She has no name.
			if ($slug == '') continue;

			// make sure there's no slug collision
			$uniqueSlug = $slug;
			$i=0;
			while (in_array($uniqueSlug, $slugs)) {
				$i++;
				$uniqueSlug = $slug . '-' . $i;
			}
			$slugs[] = $uniqueSlug;

			$age = $this->view->sanitizeAge($person['age']);
			$gender = $this->view->sanitizeGender($person['gender']);

			$sanitizedPerson = array(
				'id'			=> $person['id'],
				'first_name'	=> $person['firstName'],
				'last_name'		=> $person['surname'],
				'slug'			=> $uniqueSlug,
				'age'			=> $age,
				'gender'		=> $gender,
				'connections'	=> $person['connections'],
				'cities'		=> $person['cities']
			);

			$output[] = $sanitizedPerson;
		}

		unset($this->rawData);
		if (!count($output)) {
			throw new SocialException(SocialException::IMPORTER_CHECK_ERROR);
			return false;
		}
		$this->people = $output;
		return true;

	}

	public function insertDataIntoDatabase() {

		if (!is_array($this->people)) {
			throw new SocialException(SocialException::IMPORTER_DATASET_EMPTY);
			return false;
		}
		if (!count($this->people)) {
			throw new SocialException(SocialException::IMPORTER_DATASET_EMPTY);
			return false;
		}

		$idToDBIdRelation = array();
		$accountsTable = new Accounts_Table();

		// empty the table
		$accountsTable->delete('1');

		foreach ($this->people as $person) {

			$statement = array(
			   'first_name'		=>$person['first_name'],
			   'last_name'		=>$person['last_name'],
			   'age'			=>$person['age'],
			   'gender'			=>$person['gender'],
			   'slug'			=>$person['slug']
			);

			$dbID = $accountsTable->insert($statement);
			$importedID = $person['id'];

			// basically not trusting the ID from the data source file. Regenerating it.
			if (is_numeric($importedID) && !array_key_exists($importedID, $idToDBIdRelation)) {
				$idToDBIdRelation[$importedID] = $dbID;
			}

			foreach ($person['connections'] as $importedFriendID) {
				$connection = array(
					'account_id'	=> $dbID,
					'friend'		=> $importedFriendID
				);
				$connections[] = $connection;
			}

			foreach ($person['cities'] as $city => $rating) {
				if (!array_key_exists($city, $this->cities)) {
					$this->cities[$city] = array();
					$this->cities[$city]['sum_all_ratings'] = 0;
					$this->cities[$city]['ratings'] = array();
				}
				$newRating = array();
				$newRating['account_id'] = $dbID;
				$newRating['rating'] = $rating;
				$this->cities[$city]['ratings'][] = $newRating;
				$this->cities[$city]['sum_all_ratings'] += $rating;
			}

		}

		$connectionsTable = new Accounts_Connections_Table();
		// empty the table
		$connectionsTable->delete('1');

		foreach ($connections as $connection) {
			$friendID = $connection['friend'];
			$dbFriendID = $idToDBIdRelation[$friendID];
			if (is_numeric($dbFriendID)) {
				unset($connection['friend']);
				$connection['friend_id'] = $dbFriendID;
				$connectionsTable->insert($connection);
			}
		}

		$this->insertCityRatings();

		return true;

	}

	public function insertCityRatings() {

		$citiesTable = new Cities_Table();
		$citiesTable->delete('1');
		$citiesRatingsTable = new Cities_Ratings_Table();
		$citiesRatingsTable->delete('1');

		foreach ($this->cities as $cityName=>$cityData) {

				if (count($cityData['ratings']) == 0) {
					$cityRank = 0;
				} else {
					$cityRank = $cityData['sum_all_ratings'] / count($cityData['ratings']);
				}

				$statement = array(
				   'city_name'	=>	$cityName,
				   'rating'		=>	$cityRank
				);
				$cityDbID = $citiesTable->insert($statement);

				foreach ($cityData['ratings'] as $rating) {
					$statement = array(
					   'account_id'		=>$rating['account_id'],
					   'city_id'		=>$cityDbID,
					   'rating'			=>$rating['rating']
					);
					$citiesRatingsTable->insert($statement);
				}

		}
	}


}
