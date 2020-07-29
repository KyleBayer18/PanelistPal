DROP TABLE IF EXISTS surveys;

CREATE TABLE surveys (
survey_id SERIAL PRIMARY KEY,
title varchar(25) NOT NULL,
iamge_url varchar(255),
FOREIGN KEY (event_id) REFERENCES events (event_id)
);
ALTER TABLE surveys OWNER TO bayerk;

INSERT INTO surveys(title, iamge_url, event_id) VALUES ('Student Survey', 'student.jpg', 1);

