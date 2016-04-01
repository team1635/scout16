INSERT flat_stat
SELECT s.id,
  CASE
    WHEN (COALESCE(mr.blue_def2, m.blue_def2) = 'A_Portcullis') THEN 1
    WHEN (COALESCE(mr.blue_def3, m.blue_def3) = 'A_Portcullis') THEN 1
    WHEN (COALESCE(mr.blue_def4, m.blue_def4) = 'A_Portcullis') THEN 1
    WHEN (COALESCE(mr.blue_def5, m.blue_def5) = 'A_Portcullis') THEN 1
    ELSE 0
  END AS had_portcullis 
  , CASE
    WHEN (COALESCE(mr.blue_def2, m.blue_def2) = 'A_Portcullis') THEN COALESCE(s.cross_defense2, 0)
    WHEN (COALESCE(mr.blue_def3, m.blue_def3) = 'A_Portcullis') THEN COALESCE(s.cross_defense3, 0)
    WHEN (COALESCE(mr.blue_def4, m.blue_def4) = 'A_Portcullis') THEN COALESCE(s.cross_defense4, 0)
    WHEN (COALESCE(mr.blue_def5, m.blue_def5) = 'A_Portcullis') THEN COALESCE(s.cross_defense5, 0)
    ELSE 0
  END AS crossed_portcullis 
  , CASE
    WHEN (COALESCE(mr.blue_def2, m.blue_def2) = 'A_Portcullis') THEN COALESCE(s.open_defense2, 0)
    WHEN (COALESCE(mr.blue_def3, m.blue_def3) = 'A_Portcullis') THEN COALESCE(s.open_defense3, 0)
    WHEN (COALESCE(mr.blue_def4, m.blue_def4) = 'A_Portcullis') THEN COALESCE(s.open_defense4, 0)
    WHEN (COALESCE(mr.blue_def5, m.blue_def5) = 'A_Portcullis') THEN COALESCE(s.open_defense5, 0)
    ELSE 0
  END AS open_portcullis 
  , CASE
    WHEN (COALESCE(mr.blue_def2, m.blue_def2) = 'A_ChevalDeFrise') THEN 1
    WHEN (COALESCE(mr.blue_def3, m.blue_def3) = 'A_ChevalDeFrise') THEN 1
    WHEN (COALESCE(mr.blue_def4, m.blue_def4) = 'A_ChevalDeFrise') THEN 1
    WHEN (COALESCE(mr.blue_def5, m.blue_def5) = 'A_ChevalDeFrise') THEN 1
    ELSE 0
  END AS had_cheval 
  , CASE
    WHEN (COALESCE(mr.blue_def2, m.blue_def2) = 'A_ChevalDeFrise') THEN COALESCE(s.cross_defense2, 0)
    WHEN (COALESCE(mr.blue_def3, m.blue_def3) = 'A_ChevalDeFrise') THEN COALESCE(s.cross_defense3, 0)
    WHEN (COALESCE(mr.blue_def4, m.blue_def4) = 'A_ChevalDeFrise') THEN COALESCE(s.cross_defense4, 0)
    WHEN (COALESCE(mr.blue_def5, m.blue_def5) = 'A_ChevalDeFrise') THEN COALESCE(s.cross_defense5, 0)
    ELSE 0
  END AS crossed_cheval
  , CASE
    WHEN (COALESCE(mr.blue_def2, m.blue_def2) = 'B_Moat') THEN 1
    WHEN (COALESCE(mr.blue_def3, m.blue_def3) = 'B_Moat') THEN 1
    WHEN (COALESCE(mr.blue_def4, m.blue_def4) = 'B_Moat') THEN 1
    WHEN (COALESCE(mr.blue_def5, m.blue_def5) = 'B_Moat') THEN 1
    ELSE 0
  END AS had_moat
  , CASE
    WHEN (COALESCE(mr.blue_def2, m.blue_def2) = 'B_Moat') THEN COALESCE(s.cross_defense2, 0)
    WHEN (COALESCE(mr.blue_def3, m.blue_def3) = 'B_Moat') THEN COALESCE(s.cross_defense3, 0)
    WHEN (COALESCE(mr.blue_def4, m.blue_def4) = 'B_Moat') THEN COALESCE(s.cross_defense4, 0)
    WHEN (COALESCE(mr.blue_def5, m.blue_def5) = 'B_Moat') THEN COALESCE(s.cross_defense5, 0)
    ELSE 0
  END AS crossed_moat
  , CASE
    WHEN (COALESCE(mr.blue_def2, m.blue_def2) = 'B_Ramparts') THEN 1
    WHEN (COALESCE(mr.blue_def3, m.blue_def3) = 'B_Ramparts') THEN 1
    WHEN (COALESCE(mr.blue_def4, m.blue_def4) = 'B_Ramparts') THEN 1
    WHEN (COALESCE(mr.blue_def5, m.blue_def5) = 'B_Ramparts') THEN 1
    ELSE 0
  END AS had_ramparts
  , CASE
    WHEN (COALESCE(mr.blue_def2, m.blue_def2) = 'B_Ramparts') THEN COALESCE(s.cross_defense2, 0)
    WHEN (COALESCE(mr.blue_def3, m.blue_def3) = 'B_Ramparts') THEN COALESCE(s.cross_defense3, 0)
    WHEN (COALESCE(mr.blue_def4, m.blue_def4) = 'B_Ramparts') THEN COALESCE(s.cross_defense4, 0)
    WHEN (COALESCE(mr.blue_def5, m.blue_def5) = 'B_Ramparts') THEN COALESCE(s.cross_defense5, 0)
    ELSE 0
  END AS crossed_ramparts

  , CASE
    WHEN (COALESCE(mr.blue_def2, m.blue_def2) = 'C_Drawbridge') THEN 1
    WHEN (COALESCE(mr.blue_def3, m.blue_def3) = 'C_Drawbridge') THEN 1
    WHEN (COALESCE(mr.blue_def4, m.blue_def4) = 'C_Drawbridge') THEN 1
    WHEN (COALESCE(mr.blue_def5, m.blue_def5) = 'C_Drawbridge') THEN 1
    ELSE 0
  END AS had_drawbridge
  , CASE
    WHEN (COALESCE(mr.blue_def2, m.blue_def2) = 'C_Drawbridge') THEN COALESCE(s.cross_defense2, 0)
    WHEN (COALESCE(mr.blue_def3, m.blue_def3) = 'C_Drawbridge') THEN COALESCE(s.cross_defense3, 0)
    WHEN (COALESCE(mr.blue_def4, m.blue_def4) = 'C_Drawbridge') THEN COALESCE(s.cross_defense4, 0)
    WHEN (COALESCE(mr.blue_def5, m.blue_def5) = 'C_Drawbridge') THEN COALESCE(s.cross_defense5, 0)
    ELSE 0
  END AS crossed_drawbridge
  , CASE
    WHEN (COALESCE(mr.blue_def2, m.blue_def2) = 'C_Drawbridge') THEN COALESCE(s.open_defense2, 0)
    WHEN (COALESCE(mr.blue_def3, m.blue_def3) = 'C_Drawbridge') THEN COALESCE(s.open_defense3, 0)
    WHEN (COALESCE(mr.blue_def4, m.blue_def4) = 'C_Drawbridge') THEN COALESCE(s.open_defense4, 0)
    WHEN (COALESCE(mr.blue_def5, m.blue_def5) = 'C_Drawbridge') THEN COALESCE(s.open_defense5, 0)
    ELSE 0
  END AS open_drawbridge

  , CASE
    WHEN (COALESCE(mr.blue_def2, m.blue_def2) = 'C_SallyPort') THEN 1
    WHEN (COALESCE(mr.blue_def3, m.blue_def3) = 'C_SallyPort') THEN 1
    WHEN (COALESCE(mr.blue_def4, m.blue_def4) = 'C_SallyPort') THEN 1
    WHEN (COALESCE(mr.blue_def5, m.blue_def5) = 'C_SallyPort') THEN 1
    ELSE 0
  END AS had_sally_port
  , CASE
    WHEN (COALESCE(mr.blue_def2, m.blue_def2) = 'C_SallyPort') THEN COALESCE(s.cross_defense2, 0)
    WHEN (COALESCE(mr.blue_def3, m.blue_def3) = 'C_SallyPort') THEN COALESCE(s.cross_defense3, 0)
    WHEN (COALESCE(mr.blue_def4, m.blue_def4) = 'C_SallyPort') THEN COALESCE(s.cross_defense4, 0)
    WHEN (COALESCE(mr.blue_def5, m.blue_def5) = 'C_SallyPort') THEN COALESCE(s.cross_defense5, 0)
    ELSE 0
  END AS crossed_sally_port
  , CASE
    WHEN (COALESCE(mr.blue_def2, m.blue_def2) = 'C_SallyPort') THEN COALESCE(s.open_defense2, 0)
    WHEN (COALESCE(mr.blue_def3, m.blue_def3) = 'C_SallyPort') THEN COALESCE(s.open_defense3, 0)
    WHEN (COALESCE(mr.blue_def4, m.blue_def4) = 'C_SallyPort') THEN COALESCE(s.open_defense4, 0)
    WHEN (COALESCE(mr.blue_def5, m.blue_def5) = 'C_SallyPort') THEN COALESCE(s.open_defense5, 0)
    ELSE 0
  END AS open_sally_port

  , CASE
    WHEN (COALESCE(mr.blue_def2, m.blue_def2) = 'D_RockWall') THEN 1
    WHEN (COALESCE(mr.blue_def3, m.blue_def3) = 'D_RockWall') THEN 1
    WHEN (COALESCE(mr.blue_def4, m.blue_def4) = 'D_RockWall') THEN 1
    WHEN (COALESCE(mr.blue_def5, m.blue_def5) = 'D_RockWall') THEN 1
    ELSE 0
  END AS had_rock_wall
  , CASE
    WHEN (COALESCE(mr.blue_def2, m.blue_def2) = 'D_RockWall') THEN COALESCE(s.cross_defense2, 0)
    WHEN (COALESCE(mr.blue_def3, m.blue_def3) = 'D_RockWall') THEN COALESCE(s.cross_defense3, 0)
    WHEN (COALESCE(mr.blue_def4, m.blue_def4) = 'D_RockWall') THEN COALESCE(s.cross_defense4, 0)
    WHEN (COALESCE(mr.blue_def5, m.blue_def5) = 'D_RockWall') THEN COALESCE(s.cross_defense5, 0)
	ELSE 0
  END AS crossed_rock_wall
  
  , CASE
    WHEN (COALESCE(mr.blue_def2, m.blue_def2) = 'D_RoughTerrain') THEN 1
    WHEN (COALESCE(mr.blue_def3, m.blue_def3) = 'D_RoughTerrain') THEN 1
    WHEN (COALESCE(mr.blue_def4, m.blue_def4) = 'D_RoughTerrain') THEN 1
    WHEN (COALESCE(mr.blue_def5, m.blue_def5) = 'D_RoughTerrain') THEN 1
	ELSE 0
  END AS had_rough_terrain
  , CASE
    WHEN (COALESCE(mr.blue_def2, m.blue_def2) = 'D_RoughTerrain') THEN COALESCE(s.cross_defense2, 0)
    WHEN (COALESCE(mr.blue_def3, m.blue_def3) = 'D_RoughTerrain') THEN COALESCE(s.cross_defense3, 0)
    WHEN (COALESCE(mr.blue_def4, m.blue_def4) = 'D_RoughTerrain') THEN COALESCE(s.cross_defense4, 0)
    WHEN (COALESCE(mr.blue_def5, m.blue_def5) = 'D_RoughTerrain') THEN COALESCE(s.cross_defense5, 0)
	ELSE 0
  END AS crossed_rough_terrain
  