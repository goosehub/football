<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// echo '<br>' . $this->db->last_query() . '<br>';

Class team_model extends CI_Model
{
    function create_team($cookie_id, $team_name, $user_key, $image, $oline, $qb, $rb, $wr, $te, $dline, $lb, $db, $kicker, $special)
    {
        $data = array(
            'team_name' => $team_name,
            'user_key' => $user_key,
            'image' => $image,
            'oline_rating' => $oline,
            'qb_rating' => $qb,
            'rb_rating' => $rb,
            'wr_rating' => $wr,
            'te_rating' => $te,
            'dline_rating' => $dline,
            'lb_rating' => $lb,
            'db_rating' => $db,
            'kicker_rating' => $kicker,
            'special_rating' => $special,
            'cookie_id' => $cookie_id,
        );
        $this->db->insert('team', $data);
        return $this->db->insert_id();
    }

    function get_team($id)
    {
        $this->db->select('*');
        $this->db->from('team');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]) ? $result[0] : false;
    }
}
?>