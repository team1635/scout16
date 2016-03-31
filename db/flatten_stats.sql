SELECT COUNT(*) 
--  CASE (
FROM stat s
  JOIN match_ m
     ON s.match__id = m.id
  JOIN match_result mr
    ON m.event_id = mr.event_id
      AND m.type_ = mr.type_
      AND m.number_ = mr.number_;

SELECT COUNT(*) 
FROM stat s
  JOIN match_ m
    ON s.match__id = m.id;
    
SELECT COUNT(*) FROM match_result

    
