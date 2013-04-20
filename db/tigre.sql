drop trigger CreateJuegoMapa;
delimiter |
CREATE TRIGGER CreateJuegoMapa BEFORE INSERT ON mapa_conceptual
  FOR EACH ROW BEGIN
    INSERT INTO juego_mapa SET mapa_conceptual_id_mapa_conceptual = NEW.id_mapa_conceptual,
                               juego_id_juego = 1,
                               duracion_juego = NEW.duracion_mapa,
                               estado_juego_mapa=1;
    INSERT INTO juego_mapa SET mapa_conceptual_id_mapa_conceptual= NEW.id_mapa_conceptual,
                               juego_id_juego = 2,
                               duracion_juego = NEW.duracion_mapa,
                               estado_juego_mapa=1;
                              
                                                             
                              
  END;
|

delimiter ;