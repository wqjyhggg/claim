<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    
    /**
     * Get longitude / latitude From google base address.
     * 
     * @param string $address
     * @return number[]
     */
	public function lat_lng_finder($address = "") {
		// Get lat and long by address
		$prepAddr = str_replace(' ','+',$address);
		$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
		$output= json_decode($geocode);
		$latitude = isset($output->results[0]->geometry->location->lat) ? (float)$output->results[0]->geometry->location->lat : 43.653226;
		$longitude = isset($output->results[0]->geometry->location->lng) ? (float)$output->results[0]->geometry->location->lng : -79.3831843;
		return array('lat'=>$latitude, 'lng'=>$longitude);
	}
	
	private function get_enum_values($table, $field) {
		$type = $this->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
		preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
		$enum = explode("','", $matches[1]);
		return $enum;
	}
    
    /**
     * Select all records accoding to selected params
     *
     * @param       $record String "list/first/paginate"
     * @param       $typecast String "array/object" 
     * @param       $table String
     * @param       $fields String or array
     * @param       $conditions String
     * @param       $joins multi dimension array
     * @param       $order_by array
     * @param       $group_by array
     * @param       $having String
     * @param       $limit number
     * @return      $record array
     * @return      $offset for pagination use
    */
    public function select($record = "list", $typecast = "array", $table, $fields, $conditions = "", $joins = array(), $order_by = array(), $group_by = array(), $having = "" , $limit = 0, $offset = 0)
    {        
        // --------get all conditions here--------
        if($conditions)
            $this->db->where($conditions);

        // --------fields are goes here--------
        if($fields)
            $this->db->select("SQL_CALC_FOUND_ROWS " . $fields, FALSE);

        // ---------rows limit--------
        if($offset) 
             $this->db->limit($limit, $offset);
        if($limit)
            $this->db->limit($limit);

        // --------joins table--------
        if(!empty($joins))
            foreach ($joins as $key => $value) {
                $this->db->join($value['table'], $value['on'], $value['type']);
            }            

        // --------group by query--------
        if(!empty($group_by))
            $this->db->group_by($group_by);

        // --------for having clause--------
        if(!empty($having))
            $this->db->having($having);

        // --------order by query--------
        if(!empty($order_by))
            $this->db->order_by($order_by['field'], $order_by['order']);

        $q = $this->db->get($table);
        if($q->num_rows() > 0)
        {
            // to check type of response array or object
            if($record == 'list')
            {
                if($typecast == 'array')
                    return $q->result_array();
                else
                    return $q->result();
            }
            else if($record == 'first')
            {
                if($typecast == 'array')
                    return $q->row_array();
                else
                    return $q->row();
            }
            else if($record == 'paginate')
            {
                $data_array = [];
                $data_array['records'] = $q->result_array();

                // get no of records
                $no_of_rows = $this->db->query("SELECT FOUND_ROWS() as rows");
                $result = $no_of_rows->row_array();
                $data_array['rows'] = $result['rows'];
                return $data_array;
            }
        }
        if($record == 'paginate')
            return array('rows' => 0, 'records' => array());
        else
            return array();
    }

    /**
     * Save all records to table
     *
     * @param       $table String
     * @param       $data array
    */
    public function save($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }


    /**
     * update records to table
     *
     * @param       $table String
     * @param       $data array
     * @param       $conditions array
    */
    public function update($table,$data,$conditions)
    {
        $this->db->where($conditions);
        $q = $this->db->update($table, $data);
        return $q;
    }

    /**
     * delete records from table
     *
     * @param       $table String
     * @param       $conditions array
    */
    public function delete($table,$conditions)
    {
    	$this->db->where($conditions);
    	$this->db->delete($table);
    }

    /**
     * Check whether a value has duplicates in the database
     *
     * @param       $value String
     * @param       $tabletocheck string
     * @param       $fieldtocheck string
    */
    public function has_duplicate($value, $tabletocheck, $fieldtocheck)
    {
        $this->db->select($fieldtocheck);
        $this->db->where($fieldtocheck,$value);
        $result = $this->db->get($tabletocheck);

        if($result->num_rows() > 0) 
        {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    /**
     * Check whether the field has any reference from other table
     * Normally to check before delete a value that is a foreign key in another table
     *
     * @param       $value String
     * @param       $tabletocheck string
     * @param       $fieldtocheck string
    */
    public function has_child($value, $tabletocheck, $fieldtocheck)
    {
        $this->db->select($fieldtocheck);
        $this->db->where($fieldtocheck,$value);
        $result = $this->db->get($tabletocheck);

        if($result->num_rows() > 0) 
        {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    /**
     * Return an array to use as reference or dropdown selection
     *
     * @param       $table String
     * @param       $key string
     * @param       $value string
     * @param       $dropdown boolean
     * @param       $empty string - used for default title
     * @param       $conditions array/string
     * @param       $joins array
     * @param       $group_by array
     * @param       $group_by array
     * @param       $user_code string - emc/cm etc - to show user code intead of name
    */
    public function get_ref($table, $key, $value, $dropdown=FALSE, $empty = "Please Select", $conditions = "", $joins = array(), $group_by = array(), $user_code = FALSE)
    {
        if($user_code)
            $this->db->select("$table.$key, $table.$value, $table.id");
        else            
            $this->db->select("$table.$key, $table.$value");
        $this->db->from($table);
        // $this->db->order_by($value);

        // --------place conditions here--------
        if($conditions)
            $this->db->where($conditions);

        // group by by given id
        if(!empty($group_by))
            $this->db->group_by($group_by);

        // --------joins table--------
        if(!empty($joins))
            foreach ($joins as $join) {
                $this->db->join($join['table'], $join['on'], $join['type']);
            } 

        $result = $this->db->get();

        $array = array();
        if ($dropdown and  $empty)
            $array = array("" => $empty);

        if($result->num_rows() > 0) 
        {
            foreach($result->result_array() as $row) 
            {
                $array[$row[$key]] = $row[$value];

                if($user_code)
                    $array[$row[$key]] = $user_code.str_pad($row['id'], 4, 0, STR_PAD_LEFT);
            }
        }
        return $array;
    }

    /**
     * Return a list of payees
     *
     * @param       $field_name String
     * @param       $selected string
     * @param       $key string - option value
     * @param       $key string - option label
    */
    public function get_payees($field_name, $selected, $key = "name", $value = "name")
    {
        $record = $this->get_ref($table = "provider", $key, $value, $dropdown=TRUE, $empty = "--Select Payee--");
        return form_dropdown($field_name, $record, $selected, array("class"=>'form-control'));
    }
       

    /**
     * Return a list of countries
     *
     * @param       $field_name String
     * @param       $selected string
     * @param       $key string - option value
     * @param       $key string - option label
    */
    public function getcountries($field_name, $selected = 1, $key = "short_code", $value = "name")
    {
        $record = $this->get_ref($table = "country", $key, $value, $dropdown=TRUE, $empty = "");
        return form_dropdown($field_name, $record, $selected, array("class"=>'form-control'));
    }
    
    /**
     * Return a list of provinces
     *
     * @param       $field_name String
     * @param       $selected string
     * @param       $key string - option value
     * @param       $key string - option label
    */
    public function getprovinces($field_name, $selected, $key= "short_code", $value = "name", $conditions = "country_id = '1'")
    {
        $record = $this->get_ref($table = "province", $key, $value, $dropdown=TRUE, $empty = "", $conditions);       
        return form_dropdown($field_name, $record, $selected, array("class"=>'form-control'));
    }


    /**
     * Return a list of provinces
     *
     * @param       $field_name String
     * @param       $selected string
    */
    public function getreasons($field_name, $selected)
    {
        $record = $this->get_ref($table = "reasons", $key= "name", $value = "name", $dropdown=TRUE, $empty = "--Select Reason--");       
        return form_dropdown($field_name, $record, $selected, array("class"=>'form-control'));
    }

    /**
     * Return a list of products
     *
     * @param       $field_name String
     * @param       $selected string
     * @param       $classes boolean TRUE/FALSE to show classes - Purpose to remove classes in edit doc file 
     * @param       $short boolean TRUE/FALSE to show full value or short value of array key 
    */
	public function get_products($field_name, $selected, $classes = TRUE, $short = TRUE) {
		$this->load->model('api_model');
		$plans = $this->api_model->get_products();

		$products  = [''=>'--Select Product--'];
		foreach ($plans as $key => $value) {
			if ($short) {
				$products[$key] = $key;
			} else {
				$products[$key] = $value['full_name'];
			}
		}
		return form_dropdown($field_name, $products, $selected, array("class"=>$classes?'form-control':""));
    }
    
    /**
     * Return a list of policy status
     *
     * @param       $field_name String
     * @param       $selected string
    */
    public function get_policy_status($field_name, $selected)
    {

        // prepare post data 
        $post_data['key'] = API_KEY;
        $post_data['policy'] = "0000";


        // get list of policy status here
        $url =  API_URL."search";
        $curl = curl_init();

        // Post Data 
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

        // Optional Authentication:
        if(API_USER and API_PASSWORD)
        {
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, API_USER.":".API_PASSWORD);
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
        curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2 );
        curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        
        $result = curl_exec($curl);

        curl_close($curl);
        $result = json_decode($result, TRUE);
        $status = [''=>'--Select Policy Status--'];
        if(!empty($result['status_list']))
            foreach ($result['status_list'] as $key => $value) 
                $status[$value['status_id']] = $value['name'];
        return array(
            'dropdown'=>form_dropdown($field_name, @$status, $selected, array("class"=>'form-control')),
            'array'=>$status
            );
    }
    
    /**
     * Return a list of users
     *
     * @param       $field_name String
     * @param       $selected string
     * @param       $group group name. string/array ex- 'admin' and array("'admin'", "'manager'")
     * @param       $additional_conditions string, it should start from " and YOUR CONDITIONS" or " OR YOUR CONDITIONS"
     * @param       $user_code string, used to prefix
    */
    public function getrusers($field_name, $selected, $group = "eacmanager", $empty = "--Assign To--", $additional_conditions = "", $user_code = FALSE)
    {
        // place join to users group table to check user group
        $join[] = array(
            'table'=>'users_groups',
            'on'=>'users_groups.user_id = users.id',
            'type'=>'INNER'
            );

        // join groups table to get group name
        $join[] = array(
            'table'=>'groups',
            'on'=>'groups.id = users_groups.group_id',
            'type'=>'INNER'
            );

        // to check user type
        if(is_array($group)) // for multiple groups
            $conditions = "groups.name in(".implode(',' , $group).")";
        else
            $conditions = "groups.name='$group'";
        
        // if additional conditions exists
        if($additional_conditions)
        {
            $conditions .= $additional_conditions;
        }

        $record = $this->get_ref($table = "users", $key= "id", $value = "username", $dropdown=TRUE, $empty, $conditions, $join, $group_by = array("users.id"), $user_code);
        return form_dropdown($field_name, $record, $selected, array("class"=>'form-control'));
    }


    
    /**
     * Return a list of users based on schedule
     *
     * @param       $field_name String
     * @param       $selected string
     * @param       $group group name. string/array ex- 'admin' and array("'admin'", "'manager'")
     * @param       $additional_conditions string, it should start from " and YOUR CONDITIONS" or " OR YOUR CONDITIONS"
    */
    public function shift_users($field_name, $selected, $group = "eacmanager", $empty = "--Assign To--", $additional_conditions = "")
    {
        
        // place join to users table to get user name
        $join[] = array(
            'table'=>'schedule',
            'on'=>'users.id = schedule.employee_id',
            'type'=>'INNER'
            );

        // place join to users group table to check user group
        $join[] = array(
            'table'=>'users_groups',
            'on'=>'users_groups.user_id = users.id',
            'type'=>'INNER'
            );

        // join groups table to get group name
        $join[] = array(
            'table'=>'groups',
            'on'=>'groups.id = users_groups.group_id',
            'type'=>'INNER'
            );

        // to check user type
        if(is_array($group)) // for multiple groups
            $conditions = "groups.name in(".implode(',' , $group).")";
        else
            $conditions = "groups.name='$group'";
        
        // for today schedule only
        $conditions = "schedule.date='".date('Y-m-d')."'";

        // if additional conditions exists
        if($additional_conditions)
        {
            $conditions .= $additional_conditions;
        }

        $record = $this->get_ref($table = "users", $key= "id", $value = "first_name", $dropdown=TRUE, $empty, $conditions, $join, $group_by = array("users.id"));
        return form_dropdown($field_name, $record, $selected, array("class"=>'form-control'));
    }

    
    /**
     * Return a list of provinces
     *
     * @param       $field_name String
     * @param       $selected string
    */
    public function getrelations($field_name, $selected)
    {
        $record = $this->get_ref($table = "relations", $key= "name", $value = "name", $dropdown=TRUE, $empty = "--Select Relationship--");      
        return form_dropdown($field_name, $record, $selected, array("class"=>'form-control'));
    }

    /**
     * Return a post type data or array data
     *
     * @param       $field_name String
     * @param       $data array data
    */
    public function field_val($field_name, $data = array())
    {
        return ($this->input->post($field_name)?$this->input->post($field_name):@$data[$field_name]);
    }

    /**
     * Get an array of \DateTime objects for each day (specified) in a year and month
     *
     * @param integer $year
     * @param integer $month
     * @param string $day
     * @param integer $daysError    Number of days into month that requires inclusion of previous Monday
     * @return array|\DateTime[]
     * @throws Exception      If $year, $month and $day don't make a valid strtotime
     */
    function getAllDaysInAMonth($year, $month, $day = 'Monday', $daysError = 3) {
        $dateString = 'first '.$day.' of '.$year.'-'.$month;

        if (!strtotime($dateString)) {
            throw new \Exception('"'.$dateString.'" is not a valid strtotime');
        }

        $startDay = new \DateTime($dateString);

        if ($startDay->format('j') > $daysError) {
            $startDay->modify('- 7 days');
        }

        $days_object = array();

        while ($startDay->format('Y-m') <= $year.'-'.str_pad($month, 2, 0, STR_PAD_LEFT)) {
            $days_object[] = clone($startDay);
            $startDay->modify('+ 7 days');
        }

        // filter days
        $days = [];
        foreach ($days_object as $key => $value){
            $value = (array) $value;
            if(date('m', strtotime($value['date'])) == $month and strtotime($value['date']) >= time())
                $days[] = date("Y-m-d", strtotime($value['date']));
        }
        return $days;
    }
}