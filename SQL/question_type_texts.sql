DROP TABLE IF EXISTS question_type_texts;

CREATE TABLE question_type_texts (
question_id INT, 
FOREIGN KEY (question_id) REFERENCES questions (question_id),
max_characters INT NOT NULL,
PRIMARY KEY (question_id)
);
ALTER TABLE question_type_texts OWNER TO bayerk;

INSERT INTO question_type_texts(question_id, max_characters) VALUES (
    1,
    50);

