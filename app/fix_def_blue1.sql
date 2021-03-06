FROM stat s
  JOIN match_ m
    ON s.match__id = m.id
      AND s.team_id = m.blue_team1_id # none
  LEFT JOIN match_result mr
    ON m.event_id = mr.event_id
      AND m.type_ = mr.type_
      AND m.number_ = mr.number_;
