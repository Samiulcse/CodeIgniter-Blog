<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{
    // user login permission check

    public function can_login($user_name , $user_pass){

        $result = $this->db->select('*')->from('users')->where('username',$user_name)->where('password',$user_pass)->get()->result();

        if($result){
            return $result[0]->id;
        }else{
            return false;
        }

    }

    // get current user information

    public function get_current_user_data($user_id)
    {
        $result = $this->db->select('*')->from('users')->where('id', $user_id)->get()->result();

        return $result;
    }
}
