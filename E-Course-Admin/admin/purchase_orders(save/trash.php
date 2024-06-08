
<?php

function save_po(){
    extract($_POST);
    $data = "";
    foreach($_POST as $k =>$v){
        if(!in_array($k,array('id','po_no')) && !is_array($_POST[$k])){
            $v = addslashes(trim($v));
            if(!empty($data)) $data .=",";
            $data .= " `{$k}`='{$v}' ";
        }
    }
    if(empty($id)){
        $sql = "INSERT INTO `purchase_order` set {$data} ";
    }else{
        $sql = "UPDATE `purchase_order` set {$data} where id = '{$id}' ";
    }
    $save = $this->conn->query($sql);
    if($save){
        $resp['status'] = 'success';
        $order_id = empty($id) ? $this->conn->insert_id : $id ;
        $resp['id'] = $order_id;
        $data = "";
        foreach($item_id as $k =>$v){
            if(!empty($data)) $data .=",";
            $data .= "('{$order_id}','{$v}','{$material_id[$k]}','{$vendor_id[$k]}','{$material_name[$k]}','{$quantity[$k]}','{$price[$k]}'.' {$status[$k]}')";
        }
        if(!empty($data)){
            $this->conn->query("DELETE FROM `purchase_order` where po_id = '{$order_id}'");
            $save = $this->conn->query("INSERT INTO `purchase_order` (`po_id`,`vendor_id`,`material_id`,`quantity`,`price`) VALUES {$data} ");
        }
        if(empty($id))
            $this->settings->set_flashdata('success',"Purchase Order successfully saved.");
        else
            $this->settings->set_flashdata('success',"Purchase Order successfully updated.");
    }else{
        $resp['status'] = 'failed';
        $resp['err'] = $this->conn->error."[{$sql}]";
    }
    return json_encode($resp);
}