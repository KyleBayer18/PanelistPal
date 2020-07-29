DROP TABLE IF EXISTS calculation_methods;

CREATE TABLE calculation_methods (
calculation_method_id SERIAL PRIMARY KEY,
description varchar(30) NOT NULL
);
ALTER TABLE calculation_methods OWNER TO bayerk;

INSERT INTO calculation_methods(description) VALUES (
    'what is this nerd shit');

