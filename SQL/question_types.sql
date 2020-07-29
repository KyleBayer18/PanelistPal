DROP TABLE IF EXISTS question_types;

CREATE TABLE question_types (
question_type_id SERIAL PRIMARY KEY,
description varchar(6) NOT NULL
);
ALTER TABLE question_types OWNER TO bayerk;

INSERT INTO question_types(description) VALUES ('WTF');

