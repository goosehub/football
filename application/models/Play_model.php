<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// echo '<br>' . $this->db->last_query() . '<br>';

Class play_model extends CI_Model
{
    function get_pending_game_history_for_offense($game_key)
    {
        $this->db->select('*');
        $this->db->from('game_history');
        $this->db->where('game_key', $game_key);
        $this->db->where('offense_play_key', null);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]) ? $result[0] : false;
    }

    function get_pending_game_history_for_defense($game_key)
    {
        $this->db->select('*');
        $this->db->from('game_history');
        $this->db->where('game_key', $game_key);
        $this->db->where('is_run_stuff', null);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]) ? $result[0] : false;
    }

    function apply_outcome_to_game_history($play_id, $outcome_key)
    {
        $data['outcome_key'] = $outcome_key;
        $this->db->where('id', $play_id);
        $this->db->update('game_history', $data);
    }

    function create_game_history_for_offense($game, $play_key)
    {
        $data = $this->game_history_template($game);
        $data['offense_play_key'] = $play_key;
        $data['game_key'] = $game['id'];
        $this->db->insert('game_history', $data);
        return $this->db->insert_id();
    }

    function update_game_history_for_offense($game, $id, $play_key)
    {
        $data['offense_play_key'] = $play_key;
        $this->db->where('id', $id);
        $this->db->update('game_history', $data);
    }

    function create_game_history_for_defense($game, $is_run_stuff, $is_man, $is_blitz)
    {
        $data = $this->game_history_template($game);
        $data['is_run_stuff'] = $is_run_stuff;
        $data['is_man'] = $is_man;
        $data['is_blitz'] = $is_blitz;
        $data['game_key'] = $game['id'];
        $this->db->insert('game_history', $data);
        return $this->db->insert_id();
    }

    function update_game_history_for_defense($game, $id, $is_run_stuff, $is_man, $is_blitz)
    {
        $data['is_run_stuff'] = $is_run_stuff;
        $data['is_man'] = $is_man;
        $data['is_blitz'] = $is_blitz;
        $this->db->where('id', $id);
        $this->db->update('game_history', $data);
    }

    function get_outcome_by_play_key($play_key)
    {
        $this->db->select('*');
        $this->db->from('outcome');
        $this->db->where('offense_play_key', $play_key);
        $query = $this->db->get();
        return $query->result_array();
    }

    function game_history_template($game)
    {
        return array(
            'game_key' => $game['id'],
            'home_score' => $game['home_score'],
            'away_score' => $game['away_score'],
            'home_timeouts' => $game['home_timeouts'],
            'away_timeouts' => $game['away_timeouts'],
            'quarter' => $game['quarter'],
            'time' => $game['time'],
            'ball_on_yard_line' => $game['ball_on_yard_line'],
            'down' => $game['down'],
            'yards_to_first_down' => $game['yards_to_first_down'],
            'is_goal_to_go' => $game['is_goal_to_go'],
            'is_home_team_ball' => $game['is_home_team_ball'],
            'is_kickoff' => $game['is_kickoff'],
            'is_extra_point_attempt' => $game['is_extra_point_attempt'],
            'is_touchdown' => null,
            'is_defense_touchdown' => null,
            'is_extra_point_good' => null,
            'is_two_point_conversion_good' => null,
            'is_safety' => null,
        );
    }
}
?>