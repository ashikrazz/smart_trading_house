<?php
date_default_timezone_set("Asia/Dacca");

class my_class{
//================ Start DB Connection 1 ====================
    private $host_add1="gateway01.ap-southeast-1.prod.aws.tidbcloud.com";
    private $db_name1="mltaltd1_smt";
    private $user_name1="2EfT2LaHKjRSYpX.root";
    private $password1="AkHTEe4erTfdH2MT";


// ==========================
    public function __construct(){
        $this->con1 = new PDO("mysql:host=".$this->host_add1.";dbname=".$this->db_name1,$this->user_name1,$this->password1);
        //echo "ssdsf";
        $this->con1->exec('SET NAMES utf8');
    }
//================== End DB Connection 1 ======================
// ======================
// ===================
// ===============
// ============
// =========
// ======
// ===

//Max Value Detect Function
    public function Max_Value($table_name,$column) {
        $sql="SELECT MAX($column) AS max_value FROM $table_name";
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return isset($data)? $data :NULL;
    }
// ========================

// ===========================
    public function View_All_child($id,$type)
    {
        global $values;
        global $child;
        $sql = "SELECT _id,_type FROM _int_institute_setup where _pid=$id";
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));
        while($tag = $q->fetch(PDO::FETCH_ASSOC))
        {
            $tags[] = array('tag' => $tag['_type'], 'children' => $this->View_All_child($tag['_id'],$type) );
            if ($tag['_type']=="$type")
            {
                $values[]=array('_id'=>$tag['_id']);
                //$values[]=array($tag['_id']);
                //print_r($values);
                $child=$child.",".$tag['_id'];

            }


        }

        return $child;

    }

    public function num_of_rows($table,$where_cond=1){
        $sql='SELECT count(*) as num From '.$table.' WHERE '.$where_cond ;
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));
        $data = $q->fetch(PDO::FETCH_OBJ);
        return isset($data)? $data :NULL;
    }

// =============================
    public function Insert_Data($table_name, $form_data) {
        $fields = array_keys($form_data);

        $sql = "INSERT INTO ".$table_name."
(`".implode('`,`', $fields)."`)
VALUES('".implode("','", $form_data)."')";
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));

        return $this->con1->lastInsertId();
    }


// Insert By Check Duplicate Data Function
    public function Insert_Data_By_Cond($table_name, $form_data,$where_cond) {
        $fields = array_keys($form_data);

        $sql_select = "SELECT * FROM ".$table_name." WHERE $where_cond";
        $ch_data = $this->con1->prepare($sql_select);
        $ch_data->execute(array());
        $total = $ch_data->rowCount();

        if($total=='0'){
            $sql = "INSERT INTO ".$table_name."
    (`".implode('`,`', $fields)."`)
    VALUES('".implode("','", $form_data)."')";
            $q = $this->con1->prepare($sql);
            $q->execute() or die(print_r($q->errorInfo()));

            return $this->con1->lastInsertId();

        }
    }
// ======================
// View All Data Condition wise Function
    public function View_All_By_Cond($table_name,$where_cond) {
        $data = array();
        $sql = "SELECT * FROM $table_name WHERE $where_cond";
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));

        while ($row = $q->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        return isset($data)? $data :NULL;
    }

    public function View_All_Brand_By_Category($where_cond,$order_by) {
        $data = array();
        $sql = "SELECT pb.id,pb.name,pb.sort_order,pb.sort_order_air,pb.sort_order_ref,pb.sort_order_led,pb.sort_order_was,pb.sort_order_vrf FROM web_product pr
INNER JOIN web_product_brand pb ON pr.product_brand_ref = pb.id WHERE $where_cond GROUP BY pb.id $order_by";
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));

        while ($row = $q->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        return isset($data)? $data :NULL;
    }

    public function View_All_Product_Stock_By_Cond($where_cond,$order_by){
        $data = array();
        $sql = "SELECT p.id,p.product_title, p.product_cover_mini, p.product_regular_price,p.product_offer_price,p.product_reseller_price, p.product_publish_date, pt.product_type_title,pst.name,sm.current_stock 
	FROM web_product p
	LEFT JOIN web_product_type pt ON p.product_type_ref=pt.id
	LEFT JOIN web_product_subtype pst ON p.product_subtype_ref=pst.id
	LEFT JOIN web_stock_master sm ON p.id = sm.product_ref WHERE $where_cond $order_by";
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));

        while ($row = $q->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        return isset($data)? $data :NULL;

    }

    public function View_Product_Detail_Stock_By_Cond($where_cond,$order_by){
        $data = array();
        $sql = "SELECT p.id,p.product_title, p.product_cover_mini, p.product_regular_price,p.product_offer_price,p.product_reseller_price, p.product_publish_date, pt.product_type_title,pst.name,sm.current_stock 
	FROM web_product p
	LEFT JOIN web_product_type pt ON p.product_type_ref=pt.id
	LEFT JOIN web_product_subtype pst ON p.product_subtype_ref=pst.id
	LEFT JOIN web_stock_master sm ON p.id = sm.product_ref 
	LEFT JOIN web_stock_details sd ON p.id = sd.product_ref WHERE $where_cond $order_by";
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));

        while ($row = $q->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        return isset($data)? $data :NULL;

    }

    public function Total_Product_Stock_Count_By_Cond($where_cond) {
        $sql="SELECT COUNT(p.id) as _total FROM web_product p
LEFT JOIN web_product_type pt ON p.product_type_ref=pt.id
LEFT JOIN web_product_subtype pst ON p.product_subtype_ref=pst.id
LEFT JOIN web_stock_master sm ON p.id = sm.product_ref WHERE $where_cond";
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));
        $row = $q->fetch(PDO::FETCH_ASSOC);
        $total_count = $row['_total'];

        return isset($total_count)? $total_count :NULL;
    }

    public function View_All_Subcat_By_Category($where_cond) {
        $data = array();
        $sql = "SELECT pb.id,pb.name FROM web_product pr INNER JOIN web_product_subtype pb ON pr.product_subtype_ref = pb.id WHERE $where_cond GROUP BY pb.id ORDER BY pb.sort_order ASC";
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));
        while ($row = $q->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        return isset($data)? $data :NULL;
    }

    public function Total_Count_Subcat_By_Cond($where_cond) {
        $sql="SELECT COUNT(pr.id) _total FROM web_product pr INNER JOIN web_product_subtype pb ON pr.product_subtype_ref = pb.id WHERE $where_cond GROUP BY pb.id";
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));
        $row = $q->fetch(PDO::FETCH_ASSOC);
        $total_count = $row['_total'];

        return isset($total_count)? $total_count :NULL;
    }
// ========================

// View All Data Function
    public function View_All($table_name) {
        $data = array();
        $sql = "SELECT * FROM $table_name";
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));

        while ($row = $q->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        return isset($data)? $data :NULL;
    }
// ========================


//// View selected columns Condition wise Function (multiple data row)

    public function View_all_data_row_column_By_Cond($table_name,$column,$where_cond) {
        $data = array();
        $sql = "SELECT $column FROM $table_name WHERE $where_cond";
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));

        while ($row = $q->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        return isset($data)? $data :NULL;

    }

//==============


// Data Update Function

    function Update_Data($table_name, $form_data, $where_clause='') {

        $whereSQL = '';
        if(!empty($where_clause))
        {
            if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
            {
                $whereSQL = " WHERE ".$where_clause;
            }
            else
            {
                $whereSQL = " ".trim($where_clause);
            }
        }

        $sql = "UPDATE ".$table_name." SET ";
        $sets = array();
        foreach($form_data as $column => $value)
        {
            $sets[] = "`".$column."` = '".$value."'";
        }
        $sql .= implode(', ', $sets);
        $sql .= $whereSQL;
        $q = $this->con1->prepare($sql);

        return $q->execute() or die(print_r($q->errorInfo()));

    }
// =========================
// Delete Data Function
    function Delete_Data($table_name,$where_cond) {
        $sql = "delete FROM $table_name WHERE $where_cond";
        $q = $this->con1->prepare($sql);
        $data = $q->execute() or die(print_r($q->errorInfo()));

        return isset($data)? $data :NULL;
    }
// ========================
//Row Count By Condition Function
    public function Total_Count_By_Cond($table_name,$where_cond) {
        $sql="SELECT COUNT(*) _total FROM $table_name WHERE $where_cond";
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));
        $row = $q->fetch(PDO::FETCH_ASSOC);
        $total_count = $row['_total'];

        return isset($total_count)? $total_count :NULL;
    }

// ========================
// Details Data View Condition Wise Function
    public function View_column_details_By_Cond($table_name,$column,$where_cond){
        $sql="SELECT $column FROM $table_name WHERE $where_cond";
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return isset($data)? $data :NULL;
    }
// ========================
    public function View_colmn_By_Cond($table_name,$columns,$where_cond) {

        $data = array();
        $sql = "SELECT $columns FROM $table_name WHERE $where_cond";
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));

        while ($row = $q->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        return isset($data)? $data :NULL;
    }

// ========================
// Branch Derails \\
    public function View_branch_details_By_Cond($_pid){
        $sql='SELECT 
      (i._name) as insName,
      (id._code_name) as insCodeName, 
      d.*, 
      dv._name as division_name, 
      dis._name as distrinc_name ,
      tn._name as thana_name 
      FROM 
        _int_institute_setup i
        LEFT JOIN  _int_institute_setup b on i._id = b._pid
         LEFT JOIN _int_inst_br_details d ON b._id = d._pid AND d._type = "B"  
         LEFT JOIN _int_inst_br_details id ON i._id = id._pid AND id._type = "I" 
        LEFT JOIN _int_country dv ON  d._division = dv._id AND dv._type = "DV" 
       LEFT JOIN  _int_country dis ON  d._district = dis._id  AND  dis._type = "DC"
      LEFT JOIN  _int_country tn ON d._thana = tn._id AND tn._type = "TH" 
    WHERE 
      b._id="' . $_pid .'" AND b._type = "B"   ';
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));
        $data = $q->fetch(PDO::FETCH_OBJ);
        return isset($data)? $data :NULL;
    }

// ========================================================================

// Details Data View Condition Wise Function
    public function Details_By_Cond($table_name,$where_cond){

        $sql="SELECT * FROM $table_name WHERE $where_cond";
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return isset($data)? $data :NULL;
    }
// ========================
    public function View_std_prof($where_cond) {
        $data = array();
        $sql = "SELECT pf_std._id,
       pf_std._status,
       bsf._id AS _basic_id,
       sc._id AS _sc_id,
       sc._name AS _sc_name,
       st._id AS _st_id,
       st._name AS _st_name,
       dp._id AS _dp_id,
       dp._name AS _dp_name,
       cl._id AS _cl_id,
       cl._name AS _cl_name,
       me._id AS _me_id,
       me._name AS _me_name,
       sh._id AS _sh_id,
       sh._name AS _sh_name,
       br._id AS _br_id,
       br._name AS _br_name,
       i._id AS _ins_id,
       i._name AS _ins_name,
       pf_std._uniq_id,
       pf_std._class_roll,
       pf_std._section_roll,
       pf_std._nick_name,
       pf_std._birth_reg_no,
       pf_std._full_name AS _full_name ,
       pf_std._date_of_birth,
       bg._id AS _blood_id,
       bg._name AS _blood,
       pf_std._gender,
       rg._id AS _religion_id,
       rg._name AS _religion,
       pf_std._nationality,
       qt._id AS _quata_id,
       qt._name AS _quata,
       pf_std._std_mobile,
       pf_std._contact_email,
       pf_std._contact_mobile,
       pf_std._current_guardian,
       pf_std._image_location,
       pf_std._comments,
	   pf_std._residency_status
  FROM (((((((((((_pf_std_basic_info bsf
                  left JOIN _int_institute_setup sc
                     ON (bsf._section_id = sc._id))
                 left JOIN _int_institute_setup st
                    ON (sc._pid = st._id))
                left JOIN _int_institute_setup dp
                   ON (st._pid = dp._id))
               left JOIN _int_institute_setup cl
                  ON (dp._pid = cl._id))
              left JOIN _int_institute_setup me
                 ON (cl._pid = me._id))
             left JOIN _int_institute_setup sh
                ON (me._pid = sh._id))
            left JOIN _int_institute_setup br
               ON (sh._pid = br._id))
           left JOIN _int_institute_setup i ON (br._pid = i._id))
          left JOIN _pf_std_personal_info pf_std
             ON (pf_std._id = bsf._pid))
         left JOIN _int_common_setup bg
            ON (pf_std._blood_group_id = bg._id))
        left JOIN _int_common_setup rg
           ON (pf_std._religion = rg._id))
       left JOIN _int_common_setup qt
          ON (pf_std._quota_id = qt._id)
      where $where_cond";
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));

        while ($row = $q->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        return isset($data)? $data :NULL;

    }
    public function Std_wise_progressing_report($std_id, $section_id, $session_id, $term_id,$subject_list){
        $sql = "SELECT iss._std_id,
                  emse._subject_id,
                  emse._subject_type,
                  emse._combined_sub_id,
                  emse._subj_marks _obt_subj_marks,
                  emse._obj_marks _obt_obj_marks ,
                  emse._ct_marks _obt_ct_marks,
                  emse._pract_marks _obt_pract_marks,
                  emse._spot_marks _obt_spot_marks,
                  emse._total_marks _obt_total_marks,
                  emse._gpa _obt_gpa,
                  emse._grade _obt_grade,
                  emse._status,
                  emse._comments,
                  emse._subj_count_marks _obt_subj_count_marks,
                  emse._obj_count_marks _obt_obj_count_marks,
                  emse._ct_count_marks _obt_ct_count_marks,
                  emse._pract_count_marks _obt_pract_count_marks,
                  emse._spot_count_marks _obt_spot_count_marks,
                  emse._total_count_marks _obt_total_count_marks,

                  isub._subject_catagori,
                  isub._subject_full_name,
                  isub._subject_short_name,
                  isub._subject_code,
                  isub._full_asign_mark,
                  isub._full_count_mark,
                  isub._pass_mark_percent,
                  isub._subjective_asign_mark,
                  isub._subjective_count_mark,
                  isub._subjective_pass_mark,
                  isub._objective_asign_mark,
                  isub._objective_count_mark,
                  isub._objective_pass_mark,
                  isub._ct_asign_mark,
                  isub._ct_count_mark,
                  isub._ct_pass_mark,
                  isub._practical_asign_mark,
                  isub._practical_count_mark,
                  isub._practical_pass_mark,
                  isub._spot_asign_mark,
                  isub._spot_count_mark,
                  isub._spot_pass_mark
                FROM _int_select_subject iss, _ex_mark_sheet_entry emse
                  left JOIN  _int_subject isub ON (emse._subject_id = isub._id)
                where iss._std_id = emse._std_id and 
				iss._section_id='{$section_id}' 
				and iss._session='{$session_id}' 
				and iss._std_id=emse._std_id
                and emse._std_id='{$std_id}'
                and emse._term_id = '{$term_id}'
				and emse._session='{$session_id}'
				and isub._id IN ({$subject_list}) ORDER BY isub._order_no ASC";


        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));

        $row_num = 0;
        while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
            $row_num++;
        }
        return isset($data) ? $data : NULL;
    }

    public function std_subject_details_By_Cond($table_name,$where_cond){
        $sql="SELECT CONCAT(
			IF (_main_sub_ids='' OR ISNULL(_main_sub_ids) ,'0',_main_sub_ids),',',
			IF (_3rd_sub_id='' OR ISNULL(_3rd_sub_id),'0',_3rd_sub_id),',',
			IF (_4th_sub_id='' OR ISNULL(_4th_sub_id),'0',_4th_sub_id),',',
			IF (_non_value_sub_ids='' OR ISNULL(_non_value_sub_ids),'0',_non_value_sub_ids)) 
			asign_sub FROM $table_name WHERE $where_cond";
        //$sql="SELECT CONCAT(_main_sub_ids,',',_3rd_sub_id,',',_4th_sub_id) asign_sub FROM $table_name WHERE $where_cond";
        //SELECT CONCAT(IF (_main_sub_ids='' OR ISNULL(_main_sub_ids) ,'0',_main_sub_ids),',',IF (_3rd_sub_id='' OR ISNULL(_3rd_sub_id),'0',_3rd_sub_id),',',IF (_4th_sub_id='' OR ISNULL(_4th_sub_id),'0',_4th_sub_id),',',IF (_non_value_sub_ids='' OR ISNULL(_non_value_sub_ids),'0',_non_value_sub_ids)) asign_sub FROM `_int_select_subject` WHERE _std_id=777
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return isset($data)? $data :NULL;
    }

    public function std_invoice_std_list($br_id,$std_id,$session) {
        $data = array();
        $sql = "SELECT fm_inv._id,
       fm_inv._br_id,
       ins.shift_id,
       ins.shift,
       ins.medium_id,
       ins.medium,
       ins.class_id,
       ins.class,
       ins.department_id,
       ins.department,
       ins.student_type_id,
       ins.student_type,
       ins.section_id,
       ins.section,
       fm_inv._std_id,
       std._uniq_id,
       std._class_roll,
       std._section_roll,
       std._full_name,
       std._nick_name,
       std._contact_mobile,
       std._contact_email,
       fm_inv._month,
       fm_inv._year,
       fm_inv._invoice_no,
       fm_inv._total_amount,
       fm_inv._due_amount,
       fm_inv._paid_amount,
       fm_inv._last_paid_amount,
       fm_inv._status
  FROM (_fee_master_invoice fm_inv
        left JOIN _pf_std_personal_info std
           ON (fm_inv._std_id = std._id))
       left JOIN _int_institute_setup_vw ins
          ON (fm_inv._section_id = ins.section_id)
          
  WHERE fm_inv._br_id='$br_id' AND fm_inv._std_id='$std_id' AND fm_inv._year='$session' ORDER BY CONVERT(fm_inv._month, DECIMAL) asc";
        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));

        while ($row = $q->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        return isset($data)? $data :NULL;
    }

    public function Month($month){
        $month_name='';
        if($month==1){ $month_name='January'; }
        elseif($month==2){ $month_name='February'; }
        elseif($month==3){ $month_name='March'; }
        elseif($month==4){ $month_name='April'; }
        elseif($month==5){ $month_name='May'; }
        elseif($month==6){ $month_name='June'; }
        elseif($month==7){ $month_name='July'; }
        elseif($month==8){ $month_name='August'; }
        elseif($month==9){ $month_name='September'; }
        elseif($month==10){ $month_name='October'; }
        elseif($month==11){ $month_name='November'; }
        elseif($month==12){ $month_name='December'; }
        else { $month_name=null; }

        return $month_name;
    }

    public function View_Employee_List($status) {
        $data = array();
        $sql = "SELECT emp._id,
       i._id AS _ins_id,
       i._name AS _ins_name,
       br._id AS _br_id,
       br._name AS _br_name,
       emp._status,
       emp._uniq_id,
       emp._full_name,
       emp._nick_name,
       emp._code_name,
       emp._image_location,
	emp._date_of_birth,
	   emp._joining_date,
	pai._address,
       bg._name AS _blood_group,
	   rg._name AS _religion,
       emp._contact_mobile_no,
       dp._name AS _department,
       dg._name AS _designation
  FROM ((((_pf_emp_personal_info emp
           LEFT JOIN _int_common_setup dp
              ON (emp._department_id = dp._id))
          LEFT JOIN _int_institute_setup br
             ON (emp._branch_id = br._id))
         LEFT JOIN _int_institute_setup i ON (br._pid = i._id))
        LEFT JOIN _int_common_setup bg
           ON (emp._blood_group_id = bg._id))
       LEFT JOIN _int_common_setup dg
          ON (emp._designation_id = dg._id)
		LEFT JOIN _int_common_setup rg
			ON (emp._religion_id = rg._id)
			LEFT JOIN _pf_address_info pai ON (emp._id = pai._pid)
 WHERE pai._info_type='present' AND pai._type='E' AND emp._status !='$status' GROUP BY emp._id";


        $q = $this->con1->prepare($sql);
        $q->execute() or die(print_r($q->errorInfo()));

        while ($row = $q->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        return isset($data)? $data :NULL;
    }
// ========================

}
