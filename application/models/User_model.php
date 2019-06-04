<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class user_model extends CI_Model
{
    // Get all users
    function get_all_users()
    {
        $this->db->select('id, username, created');
        $this->db->from('user');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    function get_this_user()
    {
        // Default to user as false
        $user = false;

        // Get user by session
        if ($this->session->userdata('user_session')) {
            $session_data = $this->session->userdata('user_session');
            $user = $this->user_model->get_user_by_id($session_data['id']);
            if (!isset($user['username'])) {
                redirect('user/logout', 'refresh');
                exit();
                return false;
            }
            $this->user_loaded($user['id']);
        }

        // Get user by api key
        else if ($this->input->get('api')) {
            $input = get_json_post(false);
            if (isset($input->user_id) && isset($input->api_key)) {
                $user_auth = $this->user_model->get_user_auth_by_id($input->user_id);
                if (!isset($user_auth['api_key']) || !hash_equals($user_auth['api_key'], $input->api_key)) {
                    $this->output->set_status_header(401);
                    echo api_error_response('bad_auth', 'Your user_id, api_key combination was incorrect');
                    exit();
                }
                $user = $this->get_user_by_id($user_auth['id']);
                $this->user_loaded($user['id']);
            }
        }

        // Return user
        return $user;
    }
    function get_user_by_id($user_id)
    {
        $this->db->select('id, username, created');
        $this->db->from('user');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]) ? $result[0] : false;
    }
    function get_user_auth_by_id($user_id)
    {
        $this->db->select('id, username, password, api_key');
        $this->db->from('user');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return isset($result[0]) ? $result[0] : false;
        }
        else {
            return false;
        }
    }
    function get_user_auth_by_username($username)
    {
        $this->db->select('id, username, password, api_key');
        $this->db->from('user');
        $this->db->where('username', $username);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return isset($result[0]) ? $result[0] : false;
        }
        else {
            return false;
        }
    }
    function register($username, $password, $api_key, $email, $ip, $register_ip_frequency_limit_minutes, $ab_test)
    {
        // Check for excessive IPs registers
        $this->db->select('id');
        $this->db->from('user');
        $this->db->where('ip', $ip);
        $this->db->where('created > NOW() - INTERVAL ' . $register_ip_frequency_limit_minutes . ' MINUTE');
        $this->db->limit(1);
        $query = $this->db->get();

        // Failed register ip frequency limit
        if (!is_dev() && $query->num_rows() > 0) {
            return 'ip_fail';
        }

        // Check for existing username
        $this->db->select('username');
        $this->db->from('user');
        $this->db->where('username', $username);
        $this->db->limit(1);
        $query = $this->db->get();

        // Username already exists
        if ($query->num_rows() > 0) {
            return false;
        }
        // Register
        else {
            // Insert user into user
            $data = array(
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'api_key' => $api_key,
            'email' => $email,
            'ip' => $ip,
            'ab_test' => $ab_test,
            );
            $this->db->insert('user', $data);

            // Return user id
            $this->db->select_max('id');
            $this->db->from('user');
            $this->db->limit(1);
            $query = $this->db->get()->row();
            $user_id = $query->id;
            return $user_id;
        }
    }
    function user_loaded($user_id)
    {
        $data = array(
            'last_load' => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $user_id);
        $this->db->update('user', $data);
        return true;
    }

}
?>