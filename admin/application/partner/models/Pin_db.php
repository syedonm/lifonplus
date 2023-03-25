<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pin_db extends CI_Model{

    function getPinList($det){
        //echo '<pre>';print_r($det);exit;
        $post_data = $this->input->post(null, true);
        $order_column = array("p.id","p.id","pa.code","pa.company_name","p.type","p.type","pin.qty","pin.pin_amt","pin.total_amt");
        $select = "p.id,pa.id as pid,if(p.type=1,'Package',if(p.type=2,'Service','Equipment/Item')) as pintype,p.type,
                   i.name as item,pp.name as package,s.name as service,pin.pin_amt,pin.total_amt,pin.qty,pa.code,pa.company_name,pin.created_at,ppt.from_partner,ppt.to_partner";
        $this->db->select($select);
        $this->db->from('partner_pins pin')
                ->join('partners pa','pa.id = pin.partner_id')
                ->join('partner_pin_transaction ppt','ppt.partner_id = pa.id')
                ->join('pins p','p.id=pin.pin_id')
                ->join('items i','i.id=p.item_id','left')
                ->join('packages pp','pp.id=p.package_id','left')
                ->join('services s','s.id=p.service_id','left')
                ->join('category c','c.id=p.cat_id','left')
                ->join('subcategory sub','sub.id=p.subcat_id','left')
                ->group_by('p.id');
        
        $where = array("p.status"=>1,"pin.partner_id"=>$det[0]->partner_id,"pin.status"=>1);
        if( !empty($post_data['form'][0]["value"]) ){ $where['p.type'] = $post_data['form'][0]["value"]; }
        if( !empty($post_data['form'][1]["value"]) ){ $where['pp.id'] = $post_data['form'][1]["value"]; }
        if( !empty($post_data['form'][2]["value"]) ){ $where['c.id'] = $post_data['form'][2]["value"]; }
        if( !empty($post_data['form'][3]["value"]) ){ $where['sub.id'] = $post_data['form'][3]["value"]; }
        if( !empty($post_data['form'][4]["value"]) ){ $where['i.id'] = $post_data['form'][4]["value"]; }
        if( !empty($post_data['form'][5]["value"]) ){ $where['s.id'] = $post_data['form'][5]["value"]; }
        $this->db->where($where);

        if(isset($post_data["search"]["value"])){
            $this->db->where(" ( 
                i.name like '%{$post_data["search"]["value"]}%' or pp.name like '%{$post_data["search"]["value"]}%' or
                s.name like '%{$post_data["search"]["value"]}%' or pin.pin_amt like '%{$post_data["search"]["value"]}%' or
                pin.qty like '%{$post_data["search"]["value"]}%' or pin.total_amt like '%{$post_data["search"]["value"]}%'
            ) ");
        }

        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("p.id desc");
        }
        
        if(isset($post_data["length"]) && $post_data["length"] != -1){
            if($post_data['start'] > 0){
                $this->db->limit($post_data['length'], $post_data['start']);
            }else{
                $this->db->limit($post_data['length']);
            }
        }
        $q = $this->db->get();
        //echo $this->db->last_query();exit;
        return $q !== FALSE ? $q->result() : array();        
    }

    function getPin($pin_id){
        $select = "p.id,if(p.type=1,'Package',if(p.type=2,'Service','Equipment/Item')) as pintype,p.type,p.qty,
                  i.name as item,pp.name as package,s.name as service,c.name as category,sub.name subcategory";
        $this->db->select($select);
        $this->db->from('pins p')
                ->join('items i','i.id=p.item_id','left')
                ->join('packages pp','pp.id=p.package_id','left')
                ->join('services s','s.id=p.service_id','left')
                ->join('category c','c.id=p.cat_id','left')
                ->join('subcategory sub','sub.id=p.subcat_id','left');

        $where = array("p.status"=>1,"p.id"=>$pin_id);
        $this->db->where($where);     
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();           

    }

    function getPinHistory($pin_id){
        $select = "p.id,h.action,h.qty,h.txn_id,DATE_FORMAT(h.created_at,'%d-%m-%Y %h:%i %p') as created_at";
        $this->db->select($select);
        $this->db->from('pins p')
            ->join('pin_history h','h.pin_id=p.id');

        $where = array("p.status"=>1,"h.pin_id"=>$pin_id);
        $this->db->order_by("h.id desc");
        $this->db->where($where);     
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();           
    }

    function getPartner($db =''){
        $select = "p.id,p.company_name,pp.fullname,p.code,c.name as country,pp.address,
                    p.gst_no,p.type,pp.country_id,pp.state_id,p.pan_no,pp.emailid as email";
        $this->db->select($select);
        $this->db->from('partners p')
            ->join('partner_personal pp','pp.partner_id=p.id')
            ->join('countries c','c.id=pp.country_id','left');
        $where = array("p.verified"=>1);
        $this->db->where($where);     
        if( $db != '' ){ $this->db->where($db); }
        $this->db->order_by("p.code asc");
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }


    function getPartnerListdata($db =''){
        $select = "p.id,p.company_name,pp.fullname,p.code,c.name as country,pp.address,
                    p.gst_no,p.type,pp.country_id,pp.state_id,p.pan_no,pp.emailid as email";
        $this->db->select($select);
        $this->db->from('partners p')
            ->join('partner_personal pp','pp.partner_id=p.id')
            ->join('countries c','c.id=pp.country_id','left');
        $where = array("p.verified"=>1);
        $this->db->where($where);     
        if( $db != '' ){ $this->db->where($db); }
        $this->db->order_by("p.code asc");
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getPartnerLocation($db =''){
        $select = "l.id,l.partner_id,l.country_id,l.state_id,s.tax_type,s.name";
        $this->db->select($select);
        $this->db->from('partners p')
            ->join('partner_location l','l.partner_id=p.id')
            ->join('countries c','c.id=l.country_id')
            ->join('states s','s.id=l.state_id');
        if( $db != '' ){ $this->db->where($db); }
        $this->db->order_by("p.code asc");
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getPackages($db =''){
        $select = "p.id,p.name,p.price,pin.qty";
        $this->db->select($select);
        $this->db->from('packages p')
            ->join('pins pin','pin.package_id=p.id');
        $where = array("p.status"=>1,"pin.status"=>1);
        $this->db->where($where);     
        if( $db != '' ){ $this->db->where($db); }
        $this->db->order_by("p.name asc");
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getServicePins($db =''){
        $select = "s.id,s.name,s.price,pin.qty";
        $this->db->select($select);
        $this->db->from('services s')
            ->join('pins pin','pin.service_id=s.id');
        $where = array("s.status"=>1,"pin.status"=>1);
        $this->db->where($where);     
        if( $db != '' ){ $this->db->where($db); }
        $this->db->order_by("s.name asc");
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getItemPins($db =''){
        $select = "i.id,i.name,i.price,pin.qty";
        $this->db->select($select);
        $this->db->from('items i')
            ->join('pins pin','pin.item_id=i.id');
        $where = array("i.status"=>1,"pin.status"=>1);
        $this->db->where($where);     
        if( $db != '' ){ $this->db->where($db); }
        $this->db->order_by("i.name asc");
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getTransferList($det){
        $post_data = $this->input->post(null, true);
        
        $order_column = array("ppt.id","ppt.id","p.type","p.type","p.qty");
        $select = "ppt.id,if(p.type=1,'Package',if(p.type=2,'Service','Equipment/Item')) as pintype,p.type,
                  i.name as item,pp.name as package,s.name as service,ppt.id as txn_id,ppt.txn_no,ppt.qty,
                  DATE_FORMAT(ppt.created_at,'%d-%m-%Y %h:%i %p') as created_at,ppt.pin_amt,ppt.grand_total as total_amt,
                  if(ppt.ttype=1,'Credit','Debit') as ttype,pa.code,pa.company_name,ppl.fullname,ppl.contactno,ppl.emailid,ppt.type as transfer_type,
                  ppt.gst,ppt.gst_per,ppt.gst_type,t.name as taluk_name";
        $this->db->select($select);
        $this->db->from('pins p')
                ->join('partner_pins ppin','ppin.pin_id = p.id')
                ->join('partner_pin_transaction ppt','ppt.pin_id = ppin.pin_id')
                ->join('partners pa','pa.id = ppt.to_partner')
				->join('partner_personal ppl','pa.id = ppl.partner_id')
                ->join('items i','i.id=p.item_id','left')
                ->join('packages pp','pp.id=p.package_id','left')
                ->join('services s','s.id=p.service_id','left')
                ->join('category c','c.id=p.cat_id')
                ->join('subcategory sub','sub.id=p.subcat_id','left')
				->join('cities t','t.id=ppl.taluk_id','left');
        
        $where = array("p.status"=>1,"ppin.partner_id"=>$det[0]->partner_id,"ppt.partner_id"=>$det[0]->partner_id);
        if( !empty($post_data['form'][0]["value"]) ){ $where['p.type'] = $post_data['form'][0]["value"]; }
        if( !empty($post_data['form'][1]["value"]) ){ $where['t.txn_no'] = $post_data['form'][1]["value"]; }

        $fromdate = $todate = $condition = '';
        if( !empty($post_data['form'][2]["value"]) ){
            $fromdate = date('Y-m-d',strtotime($post_data['form'][2]["value"]));
            $fromdate = $fromdate.' 00:00:00';
            $condition .= "t.created_at >= '".$fromdate."'";
        }

        if( !empty($post_data['form'][3]["value"]) ){
            $todate = date('Y-m-d',strtotime($post_data['form'][3]["value"]));
            $todate = $todate.' 23:59:59';
            if( $condition != '' ){
                $condition .= " and t.created_at >= '".$todate."'";
            }
        }

        if( !empty($post_data['form'][4]["value"]) ){ $where['pp.id'] = $post_data['form'][4]["value"]; }
        if( !empty($post_data['form'][5]["value"]) ){ $where['c.id'] = $post_data['form'][5]["value"]; }
        if( !empty($post_data['form'][6]["value"]) ){ $where['sub.id'] = $post_data['form'][6]["value"]; }
        if( !empty($post_data['form'][7]["value"]) ){ $where['i.id'] = $post_data['form'][7]["value"]; }
        if( !empty($post_data['form'][8]["value"]) ){ $where['s.id'] = $post_data['form'][8]["value"]; }
        $this->db->where($where);
        if( $condition != '' ){
            $this->db->where($condition);
        }        

        if(isset($post_data["search"]["value"])){
            $this->db->where(" ( 
                i.name like '%{$post_data["search"]["value"]}%' or pp.name like '%{$post_data["search"]["value"]}%' or
                s.name like '%{$post_data["search"]["value"]}%' or ppt.pin_amt like '%{$post_data["search"]["value"]}%' or
                ppt.qty like '%{$post_data["search"]["value"]}%' or ppt.total_amt like '%{$post_data["search"]["value"]}%' or
                pa.code like '%{$post_data["search"]["value"]}%' or pa.company_name like '%{$post_data["search"]["value"]}%'
            ) ");
        }
        
        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("ppt.id desc");
        }
        
        if(isset($post_data["length"]) && $post_data["length"] != -1){
            if($post_data['start'] > 0){
                $this->db->limit($post_data['length'], $post_data['start']);
            }else{
                $this->db->limit($post_data['length']);
            }
        }
        $q = $this->db->get();
        //echo $this->db->last_query();exit;
        return $q !== FALSE ? $q->result() : array();        
    }

    function getPackagePin($db =''){
        $select = "p.id,ppin.pin_id,p.name,ppin.pin_amt,ppin.qty";
        $this->db->select($select);
        $this->db->from('partner_pins ppin')
            ->join('pins pin','pin.id = ppin.pin_id')
            ->join('partners pa','pa.id = ppin.partner_id')
            ->join('packages p','p.id = pin.package_id');
        $where = array("ppin.status"=>1,"pin.status"=>1,"p.status"=>1);
        $this->db->where($where);     
        if( $db != '' ){ $this->db->where($db); }
        $this->db->order_by("p.name asc");
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getItemPin($db =''){
        $select = "ppin.pin_id,i.id,i.name,ppin.pin_amt,ppin.qty";
        $this->db->select($select);
        $this->db->from('partner_pins ppin')
            ->join('pins pin','pin.id = ppin.pin_id')
            ->join('partners pa','pa.id = ppin.partner_id')
            ->join('items i','i.id = pin.item_id');
        $where = array("ppin.status"=>1,"pin.status"=>1,"i.status"=>1);
        $this->db->where($where);     
        if( $db != '' ){ $this->db->where($db); }
        $this->db->order_by("i.name asc");
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getServicePin($db =''){
        $select = "ppin.pin_id,s.id,s.name,ppin.pin_amt,ppin.qty";
        $this->db->select($select);
        $this->db->from('partner_pins ppin')
            ->join('pins pin','pin.id = ppin.pin_id')
            ->join('partners pa','pa.id = ppin.partner_id')
            ->join('services s','s.id = pin.service_id');
        $where = array("ppin.status"=>1,"pin.status"=>1,"s.status"=>1);
        $this->db->where($where);     
        if( $db != '' ){ $this->db->where($db); }
        $this->db->order_by("s.name asc");
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }
}
?>