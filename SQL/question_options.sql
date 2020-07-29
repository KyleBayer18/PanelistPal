DROP TABLE IF EXISTS question_options;

CREATE TABLE question_options (
quesiton_option_id SERIAL PRIMARY KEY,
option varchar(50) NOT NULL,
FOREIGN KEY (question_id) REFERENCES questions (question_id)
);
ALTER TABLE question_options OWNER TO bayerk;

INSERT INTO question_options(option, question_id) VALUES (
    'I honestly dont know what this is',
    1);

