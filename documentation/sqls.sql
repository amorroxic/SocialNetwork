select a.first_name, a.last_name, a.gender, a.age, a.slug from accounts as a
inner join accounts_connections as c on c.friend_id = a.account_id
where c.account_id in (
	select a.account_id from accounts as a
	inner join accounts_connections as c on c.friend_id = a.account_id
	where c.account_id = 5
) and a.account_id <> 5
and ()
group by a.account_id

// task 2
SELECT a.account_id, a.first_name, a.last_name, a.gender, a.age, a.slug
FROM accounts_connections c, accounts a
WHERE a.account_id = c.account_id
AND c.friend_id
IN (
	SELECT aa.account_id
	FROM accounts_connections cc, accounts aa
	WHERE aa.account_id = cc.account_id
	AND cc.friend_id =5
)
AND a.account_id NOT
IN (
	SELECT a.account_id
	FROM accounts_connections c, accounts a
	WHERE a.account_id = c.account_id
	AND c.friend_id =5
)
GROUP BY a.account_id

-- sau

SELECT a.account_id, a.first_name, a.last_name, a.gender, a.age, a.slug
FROM accounts a
INNER JOIN accounts_connections c ON a.account_id = c.account_id
WHERE c.friend_id IN
(
	-- get friends of friends
	SELECT a.account_id
	FROM accounts a
	INNER JOIN accounts_connections c ON a.account_id = c.account_id
	WHERE c.friend_id =5
)
AND a.account_id NOT IN
(
	-- ignore users being directly connected with the subject
	SELECT a.account_id
	FROM accounts a
	inner join accounts_connections c ON a.account_id = c.account_id
	WHERE c.friend_id =5
)
GROUP BY a.account_id



// task 3

SELECT *
FROM (

SELECT a.account_id, a.first_name, a.last_name, a.slug, count( a.account_id ) AS counting
FROM accounts_connections c, accounts a
WHERE a.account_id = c.account_id
AND c.friend_id
IN (

SELECT aa.account_id
FROM accounts_connections cc, accounts aa
WHERE aa.account_id = cc.account_id
AND cc.friend_id =5
)
AND a.account_id NOT
IN (

SELECT a.account_id
FROM accounts_connections c, accounts a
WHERE a.account_id = c.account_id
AND c.friend_id =5
)
GROUP BY a.account_id
) AS a
WHERE a.counting >=2

// task 3

SELECT first_name, last_name, gender, age, slug, common_friends
FROM (
	SELECT a.account_id, a.first_name, a.last_name, a.gender, a.age, a.slug, count( a.account_id ) AS common_friends
	FROM accounts a
	INNER JOIN accounts_connections c ON a.account_id = c.account_id
	WHERE c.friend_id IN
	(
		-- get friends of friends
		SELECT a.account_id
		FROM accounts a
		INNER JOIN accounts_connections c ON a.account_id = c.account_id
		WHERE c.friend_id =5
	)
	AND a.account_id NOT IN
	(
		-- ignore users being directly connected with the subject
		SELECT a.account_id
		FROM accounts a
		inner join accounts_connections c ON a.account_id = c.account_id
		WHERE c.friend_id =5
	)
	GROUP BY a.account_id
) AS a
WHERE a.common_friends > 1 AND a.account_id <> 5


// task 2







