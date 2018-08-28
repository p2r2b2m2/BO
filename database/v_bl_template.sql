CREATE VIEW `v_bl_template`  AS
select `j`.`id` AS `id`,
concat(`c`.`first_name`,' ',`c`.`last_name`) AS `C_NAME`,
`j`.`asl_reference_no` AS `ASL_REF`,
`j`.`c_booking_number` AS `CBN`,
`ja`.`agent_name` AS `AGENT_NAME`,
`ja`.`aga_1` AS `AG_ADDR_1`,
`ja`.`aga_2` AS `AG_ADDR_2`,
`ja`.`aga_city` AS `AG_CITY`,
`ja`.`aga_state_province` AS `AG_STATE_PROVINCE`,
`ja`.`aga_country` AS `AG_COUNTRY`,
`ja`.`agent_phone` AS `AG_PHONE`,
`j`.`load_port` AS `LOAD_PORT`,
`ja`.`pa_country` AS `PICK_UP_COUNTRY`,
`j`.`vessel_voyage` AS `VESSEL_VOYAGE`,
`j`.`discharge_port` AS `DISCHARGE_PORT`,
`j`.`final_destination` AS `FINAL_DESTINATION`,
`j`.`container_number` AS `CONTAINER_NUMBER`,
`j`.`seal_number` AS `SEAL_NUMBER`,
`e`.`type` AS `EQUIPMENT_TYPE`,
`j`.`aes_itn` AS `AES_NUMBER`,
`j`.`weight` AS `WEIGHT`,
`j`.`measure` AS `MEASUREMENT`
from (((`jobs` `j` join `customers` `c` on((`c`.`id` = `j`.`customer_id`)))
join `job_addr` `ja` on((`ja`.`job_id` = `j`.`id`)))
left join `equipment_types` `e` on((`e`.`id` = `j`.`equipment_type_id`))) ;
