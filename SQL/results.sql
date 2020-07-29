DROP TABLE IF EXISTS results;

CREATE TABLE results (
result_id SERIAL PRIMARY KEY,
value varchar(50) NOT NULL,
FOREIGN KEY (question_id) REFERENCES questions (question_id)
);
ALTER TABLE results OWNER TO bayerk;

INSERT INTO results(value, question_id) VALUES (
    'Not worth at all',
    1);

