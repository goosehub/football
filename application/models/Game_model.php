<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// echo '<br>' . $this->db->last_query() . '<br>';

Class game_model extends CI_Model
{
    function create_game($home_team_key)
    {
        $data = array(
            'home_team_key' => $home_team_key,
            'away_team_key' => null,
            'home_score' => 0,
            'away_score' => 0,
            'home_timeouts' => 3,
            'away_timeouts' => 3,
            'quarter' => 1,
            'time' => '5:00',
            'down' => 0,
            'ball_on_yard_line' => 0,
            'yards_to_goal' => 0,
            'is_hometeam_ball' => 1,
            'is_goal_to_go' => 0,
            'is_kickoff' => 1,
            'is_extra_point' => 0,
        );
        $this->db->insert('game', $data);
        return $this->db->insert_id();
    }

    function get_game($id)
    {
        $this->db->select('*');
        $this->db->from('game');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]) ? $result[0] : false;
    }

    function get_unstarted_game()
    {
        $this->db->select('*');
        $this->db->from('game');
        $this->db->where('away_team_key', NULL);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]) ? $result[0] : false;
    }

    function join_game($game_id, $team_id)
    {
        $data = array(
            'away_team_key' => $team_id,
        );
        $this->db->where('id', $game_id);
        $this->db->update('game', $data);
    }

    function get_game_last_play($game_id, $last_play_id)
    {
        $this->db->select('*');
        $this->db->from('game_history');
        $this->db->where('id', '>', $last_play_id);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]) ? $result[0] : false;
    }

    function get_offense_plays()
    {
        $this->db->select('*');
        $this->db->from('offense_play');
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>