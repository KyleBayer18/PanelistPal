DROP TABLE IF EXISTS result_criterias;

CREATE TABLE result_criterias (
result_critera_id SERIAL PRIMARY KEY,
title varchar(30) NOT NULL,
FOREIGN KEY (calculation_method_id) REFERENCES calculation_methods (calculation_method_id),
FOREIGN KEY (survey_id) REFERENCES surveys (survey_id)
);
ALTER TABLE result_criterias OWNER TO bayerk;

INSERT INTO result_criterias(title, calculation_method_id, survey_id ) VALUES (
    'Score',
    1,
    1);

