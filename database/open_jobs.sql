SELECT j.id,j.asl_reference_no,j.invoice_number,c.name as customer,m.mission_name,jt.type,CASE WHEN j.sail_date = '0000-00-00' THEN NULL ELSE j.sail_date END as 'sail_date'
,CASE WHEN j.eta = '0000-00-00' THEN NULL ELSE j.eta END as 'eta' ,jc.file_closed,
CASE WHEN jc.invoiced_date = '0000-00-00' THEN NULL ELSE jc.invoiced_date END as 'invoiced_date',
CASE WHEN jc.payment_date = '0000-00-00' THEN NULL ELSE jc.payment_date END as 'payment_date',
ss.status,
j.final_destination
from jobs j
inner join  customers c ON c.id = j.customer_id
left join missions m on m.id = c.mission_id
inner join job_types jt on jt.id = j.job_type_id
inner join doc_control jc on jc.job_id = j.id
left join status_history sh on sh.id = j.status_history_id
left join shipment_status ss ON ss.id = sh.status_id
where (jc.file_closed ='0000-00-00' or jc.file_closed IS NULL)
order by j.id DESC
