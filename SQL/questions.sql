DROP TABLE IF EXISTS questions;

CREATE TABLE questions (
question_id SERIAL PRIMARY KEY,
prompt varchar(60) NOT NULL,
is_requrired BOOLEAN,
FOREIGN KEY (question_type_id) REFERENCES question_types (question_type_id),
FOREIGN KEY (survey_id) REFERENCES surveys (survey_id)
);
ALTER TABLE questions OWNER TO bayerk;

INSERT INTO questions(prompt, is_requrired, question_type_id, survey_id) VALUES ('Is this a waste of time?', TRUE, 1, 1);

