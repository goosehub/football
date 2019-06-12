<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// echo '<br>' . $this->db->last_query() . '<br>';

Class play_model extends CI_Model
{
    function get_pending_game_history_for_offense($game_id)
    {
        $this->db->select('*');
        $this->db->from('game_history');
        $this->db->where('game_key', $game_id);
        $this->db->where('defense_play_key', null);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]) ? $result[0] : false;
    }

    function get_pending_game_history_for_defense($game_id)
    {
        $this->db->select('*');
        $this->db->from('game_history');
        $this->db->where('game_key', $game_id);
        $this->db->where('offense_play_key', null);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]) ? $result[0] : false;
    }

    function create_game_history_for_offense($play_key, $game)
    {
        $data = array(
            'offense_play_key' => $play_key,
            'game_key' => $game['id'],
            'time' => $game['time']
        );
        $this->db->insert('game_history', $data);
        return $this->db->insert_id();
    }

    function update_game_history_for_offense($id, $game, $id)
    {
        $data = array(
            'offense_play_key' => $play_key,
            'time' => $game['time']
        );
        $this->db->where('id', $id);
        $this->db->update('game_history', $data);
    }

    function create_game_history_for_defense($play_key, $game)
    {
        $data = array(
            'defense_play_key' => $play_key,
            'game_key', $game['id'],
            'time' => $game['time']
        );
        $this->db->insert('game_history', $data);
        return $this->db->insert_id();
    }

    function update_game_history_for_defense($id, $game, $id)
    {
        $data = array(
            'defense_play_key' => $play_key,
            'time' => $game['time']
        );
        $this->db->where('id', $id);
        $this->db->update('game_history', $data);
    }
}
?>