<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }


    function update($id)
    {
        $this->db->where('optionname','template_mail');
        $this->db->where('shipment_staus_id',$id);
        //shipment_staus_id
        $this->db->set('optionvalue',$this->input->post('activation_mail'));
        $this->db->update('tboptions');

        $this->db->where('optionname','template_subject');
        $this->db->where('shipment_staus_id',$id);
        $this->db->set('optionvalue',$this->input->post('activation_subject'));
        $this->db->update('tboptions');

        $this->db->where('optionname','template_content');
        $this->db->where('shipment_staus_id',$id);
        $this->db->set('optionvalue',$this->input->post('activation_content'));
        $this->db->update('tboptions');

    }


    function get_option($Field,$id)
    {
         $this->db->where('optionname',$Field);
         $this->db->where('shipment_staus_id',$id);
         $this->db->select('optionvalue');
         $result= $this->db->get('tboptions');
        return $result->row()->optionvalue;
    }

    function insert($id)
    {
      $sql = 'INSERT INTO tboptions (shipment_staus_id,optionname,optionvalue,lang)
      select '.$id.',optionname,optionvalue,lang
      from tboptions
      where shipment_staus_id = 0
      and optionname = \'template_mail\'
      and NOT EXISTS(
      select shipment_staus_id,optionname,optionvalue  from tboptions where shipment_staus_id= '.$id.'  and optionname = \'template_mail\')
      LIMIT 1';
      $this->db->query($sql);

      $sql = 'INSERT INTO tboptions (shipment_staus_id,optionname,optionvalue,lang)
      select '.$id.',optionname,optionvalue,lang
      from tboptions
      where shipment_staus_id = 0
      and optionname = \'template_subject\'
      and NOT EXISTS(
      select shipment_staus_id,optionname,optionvalue  from tboptions where shipment_staus_id= '.$id.'  and optionname = \'template_subject\')
      LIMIT 1';
      $this->db->query($sql);

      $sql = 'INSERT INTO tboptions (shipment_staus_id,optionname,optionvalue,lang)
      select '.$id.',optionname,optionvalue,lang
      from tboptions
      where shipment_staus_id = 0
      and optionname = \'template_content\'
      and NOT EXISTS(
      select shipment_staus_id,optionname,optionvalue  from tboptions where shipment_staus_id= '.$id.'  and optionname = \'template_content\')
      LIMIT 1';
      $this->db->query($sql);

    }



/*
    INSERT INTO tboptions (shipment_staus_id,optionname,optionvalue,lang)
    select 2,optionname,optionvalue,lang
    from tboptions
    where shipment_staus_id = 0
    and optionname = 'template_mail'
    and NOT EXISTS(
    select shipment_staus_id,optionname,optionvalue  from tboptions where shipment_staus_id= 2  and optionname = 'template_mail')
    LIMIT 1
    */
}
