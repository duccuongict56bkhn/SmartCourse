/**
 *
 **/

CREATE FUNCTION fnc_course_wload(course_id INT)
RETURNS DECIMAL(10, 0)
READS SQL DATA 
BEGIN

DECLARE v_wload INT(10);

SELECT SUM(`sm_exercises`.`score`) INTO v_wload
FROM `sm_exercises`
WHERE `sm_exercises`.`course_id` = course_id;

RETURN v_wload;

END