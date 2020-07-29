DROP TABLE IF EXISTS events;

CREATE TABLE events (
event_id SERIAL PRIMARY KEY,
event_code varchar(6) NOT NULL UNIQUE,
title varchar(25) NOT NULL,
description varchar(200) NOT NULL,
image_url VARCHAR(255),
max_marticipants INT,
is_active BOOLEAN,
FOREIGN KEY (event_manager_id) REFERENCES event_managers (event_manager_id)
);
ALTER TABLE events OWNER TO bayerk;

INSERT INTO events(event_code, title, description, image_url, max_participants, is_active, event_manager_id) VALUES (
    '123456', 
    "IT EXPO 2020",
    "What expo? Didn't even happen this year.", 
    "https://www.google.com/search?q=logo+smiley&rlz=1C1NDCM_enCA783CA783&sxsrf=ALeKk02H-VRabQIMrbGdmX6j9OVdLsFG7w:1586881033231&source=lnms&tbm=isch&sa=X&ved=2ahUKEwiN_qTCqOjoAhVFJ80KHVl0AYQQ_AUoAXoECA8QAw&biw=954&bih=857#imgrc=yMjie1VvObtHZM",
    20,
    TRUE,
    1);

