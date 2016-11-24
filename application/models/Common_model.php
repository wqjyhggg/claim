<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Common Model
 *
 * @category    model
 * @author      bhawani shankar
 */
class Common_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Select all records accoding to selected params
     *
     * @param       $record String "list/first"
     * @param       $typecast String "array/object" 
     * @param       $table String
     * @param       $fields String or array
     * @param       $conditions String
     * @param       $joins multi dimension array
     * @param       $order_by array
     * @param       $group_by array
     * @param       $having String
     * @param       $limit number
     * @return      record array
    */
    public function select($record = "list", $typecast = "array", $table, $fields, $conditions = "", $joins = array(), $order_by = array(), $group_by = array(), $having = "" , $limit = 0)
    {
        // --------get all conditions here--------
        if($conditions)
            $this->db->where($conditions);

        // --------fields are goes here--------
        if($fields)
            $this->db->select($fields);

        // ---------rows limit--------
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
            else
            {
                if($typecast == 'array')
                    return $q->row_array();
                else
                    return $q->row();
            }
        }
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
            return true;
        }
        else {
            return false;
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
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Return an array to use as reference or dropdown selection
     *
     * @param       $table String
     * @param       $key string
     * @param       $value string
     * @param       $dropdown boolean
    */
    public function get_ref($table,$key,$value,$dropdown=false, $empty = "Please Select")
    {
        $this->db->from($table);
        $this->db->order_by($value);
        $result = $this->db->get();

        $array = array();
        if ($dropdown)
            $array = array("" => $empty);

        if($result->num_rows() > 0) 
        {
            foreach($result->result_array() as $row) 
            {
                $array[$row[$key]] = $row[$value];
            }
        }
        return $array;
    }
}