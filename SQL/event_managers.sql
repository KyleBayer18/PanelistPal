DROP TABLE IF EXISTS event_managers;

CREATE TABLE event_managers (
event_manager_id SERIAL PRIMARY KEY,
email varchar(70) NOT NULL,
email_verified_at date DEFAULT "",
password varchar(256) NOT NULL
);
ALTER TABLE event_managers OWNER TO bayerk;


INSERT INTO event_managers (email, email_verified_at, password) VALUES ('test@test.com', '2020-04-13', '5f4dcc3b5aa765d61d8327deb882cf99');
