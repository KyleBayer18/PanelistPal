DROP TABLE IF EXISTS result_criteria_answers;

CREATE TABLE result_criteria_answers (
result_criteria_answer_id SERIAL PRIMARY KEY,
answer varchar(50) NOT NULL,
weight DECIMAL NOT NULL,
FOREIGN KEY (result_criteria_id) REFERENCES result_criterias (result_criteria_id),
FOREIGN KEY (question_id) REFERENCES questions (question_id)
);
ALTER TABLE result_criteria_answers OWNER TO bayerk;

INSERT INTO result_criteria_answers(answer, weight, result_criteria_id, question_id) VALUES (
    'Yes?',
    0.1,
    1,
    1);

