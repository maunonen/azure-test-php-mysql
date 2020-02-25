1.
auton id 
Hae kakki auton omistajan autot 

SELECT *
FROM auto
LEFT JOIN hlo_auto ON auto.id = hlo_auto.auto_id
WHERE auto.id = '20'



2. 
hlon id 
Hae kaikki hlon autot 

SELECT henkilot.etunimi, henkilot.sukunimi, auto.merkki, auto.rekisterinro
FROM henkilot
LEFT JOIN hlo_auto ON henkilot.id=hlo_auto.henkilo_id
LEFT JOIN auto ON auto.id = hlo_auto.auto_id
WHERE  henkilot.id = 16


3. 
SELECT last_name, first_name, title
FROM actor a 
INNER JOIN film_actor fa 
	ON a.actor_id = fa.actor_id 
INNER JOIN film f 
	ON fa.film_id = f.film_id
WHERE fa.film_id = 2 
ORDER BY last_name, first_name 

4. 
SELECT COUNT(*)
FROM actor a 
INNER JOIN film_actor fa 
	ON a.actor_id = fa.actor_id 
INNER JOIN film f 
	ON fa.film_id = f.film_id
WHERE fa.film_id = 2 
ORDER BY last_name, first_name

5. 
SELECT COUNT(a.actor_id)
FROM actor a 
INNER JOIN film_actor fa 
	ON a.actor_id = fa.actor_id 
INNER JOIN film f 
	ON fa.film_id = f.film_id
GROUP BY fa.film_id

6. 
SELECT COUNT(CustomerID), Country
FROM Customers
GROUP BY Country
HAVING COUNT(CustomerID) > 5;

7. 
SELECT AVG (c.cnt) FROM 
(
  SELECT COUNT(a.actor_id) AS cnt, fa.film_id, title
  FROM actor a 
  INNER JOIN film_actor fa 
    ON a.actor_id = fa.actor_id 
  INNER JOIN film f 
    ON fa.film_id = f.film_id
  GROUP BY fa.film_id
  HAVING COUNT(a.actor_id) >= 4
) c
GROUP BY c.film_id

8. 

    SELECT COUNT(fa.film_id) AS cnt, a.last_name, a.first_name
    FROM actor a 
    INNER JOIN film_actor fa 
    ON a.actor_id = fa.actor_id 
    INNER JOIN film f 
    ON fa.film_id = f.film_id
    GROUP BY a.actor_id
    ORDER BY cnt DESC LIMIT 1

    (
        SELECT COUNT(fa.film_id) AS cnt, a.last_name, a.first_name
        FROM actor a 
        INNER JOIN film_actor fa 
        ON a.actor_id = fa.actor_id 
        INNER JOIN film f 
        ON fa.film_id = f.film_id
        GROUP BY a.actor_id
    ) 