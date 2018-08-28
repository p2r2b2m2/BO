
CREATE VIEW `v_hbl_template`  AS
select `j`.`id` AS `id`,
concat(`c`.`first_name`,' ',`c`.`last_name`) AS `C_NAME`,
`j`.`hbl_number` AS `HBL_NUMBER`,
`j`.`c_booking_number` AS `CBN`,
`ja`.`pa_1` AS `PICK_UP_ADDR_1`,
`ja`.`pa_2` AS `PICK_UP_ADDR_2`,
`ja`.`pa_city` AS `PICK_UP_CITY`,
`ja`.`pa_state` AS `PICK_UP_STATE`,
`ja`.`pa_zip` AS `PICK_UP_ZIP`,
`ja`.`pa_country` AS `PICK_UP_COUNTRY`,
`c`.`phone` AS `C_PHONE`,
`ja`.`da_1` AS `DEST_ADDR_1`,
`ja`.`da_2` AS `DEST_ADDR_2`,
`ja`.`da_city` AS `DEST_CITY`,
`ja`.`da_state_province` AS `DEST_STATE_PROVINCE`,
`ja`.`pa_country` AS `DEST_COUNTRY`,
`j`.`load_port` AS `LOAD_PORT`,
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
