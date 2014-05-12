
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