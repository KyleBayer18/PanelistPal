DROP TABLE IF EXISTS participants;

CREATE TABLE participants (
participant_id SERIAL PRIMARY KEY,
participant_name varchar(30) NOT NULL,
FOREIGN KEY (event_id) REFERENCES events (event_id)
);
ALTER TABLE participants OWNER TO bayerk;

INSERT INTO participants(participant_name, event_id) VALUES ('Shawn Kirubakaran', 1);

