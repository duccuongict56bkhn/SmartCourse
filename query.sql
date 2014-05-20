
--- Lay danh sach tat ca cac courses ma nguoi dung dang hoc
SELECT *
FROM sm_courses AS smc, sm_enroll_course AS sme
WHERE sme.user_id = 15
AND  sme.course_id = smc.course_id

--- Dem so luong courses, group theo catagories
SELECT scat.cat_title, 0//IFNULL(COUNT(smc.course_id), 0)
FROM `sm_courses` AS smc, `sm_course_cat` AS scat
WHERE smc.cat_id = scat.cat_id
GROUP BY scat.cat_id, scat.cat_title

SELECT COUNT(`unit_id`)
FROM `sm_units`
WHERE `course_id` = 19
GROUP BY `course_id`

-- Lay bai submit theo lecture, exercise, student de giao vien cham
SELECT * 
FROM sm_do_exercise
WHERE user_id =14
AND course_id =19
AND unit_id =3
AND answer_text <>  ''
AND exercise_id =2
AND IFNULL( approved,  'N' ) <>  'Y'
AND attempt_made = ( 
SELECT MAX( attempt_made ) 
FROM sm_do_exercise
GROUP BY user_id, course_id, unit_id, exercise_id
HAVING (
user_id, course_id, unit_id, exercise_id
) = ( 14, 19, 3, 2 ) ) 