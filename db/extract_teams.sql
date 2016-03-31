INSERT INTO team
(id)
SELECT DISTINCT red_team1_id
FROM match_
WHERE event_id = 4
UNION 
SELECT DISTINCT red_team2_id
FROM match_
where event_id = 4
UNION
SELECT DISTINCT red_team3_id
FROM match_
WHERE event_id = 4 -- use 4 for LI
UNION 
SELECT DISTINCT blue_team1_id
FROM match_
where event_id = 4
UNION
SELECT DISTINCT blue_team2_id
FROM match_
WHERE event_id = 4 -- use 4 for LI
UNION 
SELECT DISTINCT blue_team3_id
FROM match_
where event_id = 4

DELETE stat
FROM stat s
  JOIN match_ m
    ON s.match__id = m.id
WHERE m.event_id = 3