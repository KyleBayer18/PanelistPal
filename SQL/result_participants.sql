DROP TABLE IF EXISTS result_participants;

CREATE TABLE result_participants (
result_participant_id SERIAL PRIMARY KEY,
FOREIGN KEY (result_id) REFERENCES results (result_id),
FOREIGN KEY (participant_id) REFERENCES participants (participant_id)
);
ALTER TABLE result_participants OWNER TO bayerk;

INSERT INTO result_participants(result_id, participant_id) VALUES (
    1,
    1);

