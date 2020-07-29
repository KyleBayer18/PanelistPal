DROP TABLE IF EXISTS result_criteria_answers;
DROP TABLE IF EXISTS result_participants;
DROP TABLE IF EXISTS result_criterias;
DROP TABLE IF EXISTS results;
DROP TABLE IF EXISTS question_options;
DROP TABLE IF EXISTS question_type_texts;
DROP TABLE IF EXISTS questions;
DROP TABLE IF EXISTS question_types;
DROP TABLE IF EXISTS calculation_methods;
DROP TABLE IF EXISTS participants;
DROP TABLE IF EXISTS surveys;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS event_managers;

CREATE TABLE event_managers (
event_manager_id SERIAL PRIMARY KEY,
email varchar(70) NOT NULL,
email_verified_at date DEFAULT NULL,
password varchar(256) NOT NULL,
hash varchar(256) NOT NULL
);
ALTER TABLE event_managers OWNER TO bayerk;

INSERT INTO event_managers (email, email_verified_at, password, hash) VALUES ('test@test.com', '2020-04-13', '5f4dcc3b5aa765d61d8327deb882cf99', 'default');

CREATE TABLE events (
event_id SERIAL PRIMARY KEY,
event_code varchar(6) NOT NULL UNIQUE,
title varchar(25) NOT NULL,
description varchar(200) NOT NULL,
image_url VARCHAR(255),
max_participants INT,
is_active BOOLEAN,
event_manager_id INT, 
FOREIGN KEY (event_manager_id) REFERENCES event_managers (event_manager_id)
);
ALTER TABLE events OWNER TO bayerk;

INSERT INTO events(event_code, title, description, image_url, max_participants, is_active, event_manager_id) VALUES (
    '123456', 
    'IT EXPO 2020',
    'What expo? Didnt even happen this year.', 
    'https://scontent.fykz1-1.fna.fbcdn.net/v/t31.0-8/28514587_556777604690565_9005672925881465746_o.jpg?_nc_cat=102&_nc_sid=6e5ad9&_nc_ohc=Z29P3JHcsGsAX_ymkQj&_nc_ht=scontent.fykz1-1.fna&oh=9681553240548dac3d2fef46ce483968&oe=5EBC415D',
    20,
    TRUE,
    1);


CREATE TABLE surveys (
survey_id SERIAL PRIMARY KEY,
title varchar(25) NOT NULL,
image_url varchar(255),
event_id INT, 
FOREIGN KEY (event_id) REFERENCES events (event_id)
);
ALTER TABLE surveys OWNER TO bayerk;

INSERT INTO surveys(title, image_url, event_id) VALUES ('Student Survey', 'https://lh3.googleusercontent.com/proxy/EWXgx_cwcfnHtpFeQP6qv9aycuzOfUYYaJWG-A0-4JGKGZ98nLPjRDSy5alFwKqQJC2wd7fVHw4nab8oTCfcCmj4u5eHpBn870Ma1tKixARIDAYiFMqXdLaQL8XrTtsP5ArXXaHjZYyx6uS6mobxYcaEoKICsKPUsEdSArfOhFVPmFuuSlbGkA', 1);


CREATE TABLE participants (
participant_id SERIAL PRIMARY KEY,
participant_name varchar(30) NOT NULL,
event_id INT, 
FOREIGN KEY (event_id) REFERENCES events (event_id)
);
ALTER TABLE participants OWNER TO bayerk;

INSERT INTO participants(participant_name, event_id) VALUES ('Shawn Kirubakaran', 1);


CREATE TABLE calculation_methods (
calculation_method_id SERIAL PRIMARY KEY,
description varchar(30) NOT NULL
);
ALTER TABLE calculation_methods OWNER TO bayerk;

INSERT INTO calculation_methods(description) VALUES (
    'what is this nerd shit');


CREATE TABLE question_types (
question_type_id SERIAL PRIMARY KEY,
description varchar(6) NOT NULL
);
ALTER TABLE question_types OWNER TO bayerk;

INSERT INTO question_types(description) VALUES ('Select');
INSERT INTO question_types(description) VALUES ('Text');


CREATE TABLE questions (
question_id SERIAL PRIMARY KEY,
prompt varchar(60) NOT NULL,
is_required BOOLEAN,
question_type_id INT,
survey_id INT, 
FOREIGN KEY (question_type_id) REFERENCES question_types (question_type_id),
FOREIGN KEY (survey_id) REFERENCES surveys (survey_id)
);
ALTER TABLE questions OWNER TO bayerk;

INSERT INTO questions(prompt, is_required, question_type_id, survey_id) VALUES ('How would you improve this Expo?', TRUE, 2, 1);
INSERT INTO questions(prompt, is_required, question_type_id, survey_id) VALUES ('Did you like this Expo?', TRUE, 1, 1);


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


CREATE TABLE question_options (
question_option_id SERIAL PRIMARY KEY,
option varchar(50) NOT NULL,
question_id INT, 
FOREIGN KEY (question_id) REFERENCES questions (question_id)
);
ALTER TABLE question_options OWNER TO bayerk;

INSERT INTO question_options(option, question_id) VALUES ('Yes', 2);
INSERT INTO question_options(option, question_id) VALUES ('No', 2);
INSERT INTO question_options(option, question_id) VALUES ('Not sure', 2);
INSERT INTO question_options(option, question_id) VALUES ('Prefer not to answer', 2);


CREATE TABLE results (
result_id SERIAL PRIMARY KEY,
value varchar(50) NOT NULL,
question_id INT, 
FOREIGN KEY (question_id) REFERENCES questions (question_id)
);
ALTER TABLE results OWNER TO bayerk;

INSERT INTO results(value, question_id) VALUES (
    'Not worth at all',
    1);


CREATE TABLE result_criterias (
result_criteria_id SERIAL PRIMARY KEY,
title varchar(30) NOT NULL,
calculation_method_id INT,
survey_id INT, 
FOREIGN KEY (calculation_method_id) REFERENCES calculation_methods (calculation_method_id),
FOREIGN KEY (survey_id) REFERENCES surveys (survey_id)
);
ALTER TABLE result_criterias OWNER TO bayerk;

INSERT INTO result_criterias(title, calculation_method_id, survey_id ) VALUES (
    'Score',
    1,
    1);


CREATE TABLE result_participants (
result_participant_id SERIAL PRIMARY KEY,
result_id INT,
participant_id INT,
FOREIGN KEY (result_id) REFERENCES results (result_id),
FOREIGN KEY (participant_id) REFERENCES participants (participant_id)
);
ALTER TABLE result_participants OWNER TO bayerk;

INSERT INTO result_participants(result_id, participant_id) VALUES (
    1,
    1);



CREATE TABLE result_criteria_answers (
result_criteria_answer_id SERIAL PRIMARY KEY,
answer varchar(50) NOT NULL,
weight DECIMAL NOT NULL,
result_criteria_id INT, 
question_id INT, 
FOREIGN KEY (result_criteria_id) REFERENCES result_criterias (result_criteria_id),
FOREIGN KEY (question_id) REFERENCES questions (question_id)
);
ALTER TABLE result_criteria_answers OWNER TO bayerk;

INSERT INTO result_criteria_answers(answer, weight, result_criteria_id, question_id) VALUES (
    'Yes?',
    0.1,
    1,
    1);

