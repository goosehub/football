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
            'yards_to_first_down' => 0,
            'is_home_team_ball' => 1,
            'is_goal_to_go' => 0,
            'is_kickoff' => 1,
            'is_extra_point_attempt' => 0,
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

    function get_game_last_play($game_id)
    {
        $this->db->select('*');
        $this->db->from('game_history');
        $this->db->where('outcome_key IS NOT NULL', null, false);
        $this->db->where('game_key', $game_id);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]) ? $result[0] : false;
    }

    function get_game_current_play($game_id)
    {
        $this->db->select('*');
        $this->db->from('game_history');
        $this->db->where('outcome_key', null);
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

    function apply_outcome_to_game_state($game, $outcome)
    {
        $outcome['is_touchdown'] = $this->is_touchdown($game, $outcome);
        $outcome['is_safety'] = $this->is_safety($game, $outcome);
        $data = array(
            'home_score' => $this->home_score($game, $outcome),
            'away_score' => $this->away_score($game, $outcome),
            // 'quarter' => $game['time'] - $outcome['seconds_off_clock_during_play'] <= 0 ? $game['quarter'] + 1 : $game['quarter'],
            // 'time' => $game['time'] - $outcome['seconds_off_clock_during_play'] > 0 ? $game['time'] - $outcome['seconds_off_clock_during_play'] : 0,
            'down' => $this->down($game, $outcome),
            'ball_on_yard_line' => $this->ball_on_yard_line($game, $outcome),
            'yards_to_first_down' => $this->yards_to_first_down($game, $outcome),
            'is_home_team_ball' => $this->is_home_team_ball($game, $outcome),
            'is_goal_to_go' => $this->is_goal_to_go($game, $outcome),
            // If was extra point, then now it's kickoff
            'is_kickoff' => $game['is_extra_point_attempt'] || $outcome['is_safety'] ? true : false,
            'is_extra_point_attempt' => $outcome['is_touchdown'] ? true : false,
        );
        $this->db->where('id', $game['id']);
        $this->db->update('game', $data);
    }

    function home_score($game, $outcome)
    {
        if (!$game['is_home_team_ball']) {
            if ($outcome['is_safety']) {
                return $game['home_score'] + 2;
            }
            if ($outcome['is_interception'] || $outcome['is_fumble']) {
                if ($outcome['is_always_td']) {
                    return $game['home_score'] + 7;
                }
            }
            return $game['home_score'];
        }
        if ($game['is_extra_point_attempt']) {
            if ($outcome['is_touchdown']) {
                return $game['home_score'] + 2;
            }
            if ($outcome['is_kick_good']) {
                return $game['home_score'] + 1;
            }
        }
        if ($outcome['is_touchdown']) {
            return $game['home_score'] + 7;
        }
        if ($outcome['is_kick_good']) {
            return $game['home_score'] + 3;
        }
        return $game['home_score'];
    }

    function away_score($game, $outcome)
    {
        if ($game['is_home_team_ball']) {
            if ($outcome['is_safety']) {
                return $game['away_score'] + 2;
            }
            if ($outcome['is_interception'] || $outcome['is_fumble']) {
                if ($outcome['is_always_td']) {
                    return $game['away_score'] + 7;
                }
            }
            return $game['away_score'];
        }
        if ($game['is_extra_point_attempt']) {
            if ($outcome['is_touchdown']) {
                return $game['away_score'] + 2;
            }
            if ($outcome['is_kick_good']) {
                return $game['away_score'] + 1;
            }
        }
        if ($outcome['is_touchdown']) {
            return $game['away_score'] + 7;
        }
        if ($outcome['is_kick_good']) {
            return $game['away_score'] + 3;
        }
        return $game['away_score'];
    }

    function is_touchdown($game, $outcome)
    {
        if ($outcome['is_always_td']) {
            return true;
        }
        if ($game['ball_on_yard_line'] + $outcome['yards'] >= 100) {
            return true;
        }
        return false;
    }

    function is_turnover($game, $outcome)
    {
        if ($outcome['is_turnover']) {
            return true;
        }
        // Turnover
        if ($outcome['yards'] < $game['yards_to_first_down']) {
            if ($game['down'] === 4) {
                return true;
            }
        }
        return false;
    }

    function is_safety($game, $outcome)
    {
        if ($outcome['yards'] + $game['ball_on_yard_line'] < 0) {
            return true;
        }
        return false;
    }

    function down($game, $outcome)
    {
        // Is now extra point
        if ($outcome['is_touchdown']) {
            return 0;
        }
        if ($outcome['is_kick_good']) {
            return 0;
        }
        // Is now kickoff
        if ($game['is_extra_point_attempt'])  {
            return 0;
        }
        if ($outcome['is_safety']) {
            return 0;
        }
        // First down
        if ($outcome['yards'] >= $game['yards_to_first_down']) {
            return 1;
        }
        // Turnover
        if ($game['down'] === 4) {
            return 1;
        }
        // Next down
        return $game['down'] + 1;
    }

    function ball_on_yard_line($game, $outcome)
    {
        // Is now extra point
        if ($outcome['is_touchdown']) {
            return 98;
        }
        if ($outcome['is_kick_good']) {
            return 98;
        }
        // Is now kickoff
        if ($game['is_extra_point_attempt'])  {
            return 0;
        }
        if ($outcome['is_safety']) {
            return 0;
        }
        return $game['ball_on_yard_line'] + $outcome['yards'];
    }

    function yards_to_first_down($game, $outcome)
    {
        // Is now extra point
        if ($outcome['is_touchdown']) {
            return 0;
        }
        if ($outcome['is_kick_good']) {
            return 0;
        }
        // Is now kickoff
        if ($game['is_extra_point_attempt'])  {
            return 0;
        }
        if ($outcome['is_safety']) {
            return 0;
        }
        // First down
        if ($outcome['yards'] >= $game['yards_to_first_down']) {
            // Is to goal first down
            if ($this->ball_on_yard_line($game, $outcome) + 10 > 100) {
                return 100 - $this->ball_on_yard_line($game, $outcome);
            }
            return 10;
        }
        return $game['yards_to_first_down'] - $outcome['yards'];
    }

    function is_home_team_ball($game, $outcome)
    {
        // Was just kickoff
        if ($game['is_kickoff'])  {
            return !$game['is_home_team_ball'];
        }
        // Was turnover
        if ($outcome['is_turnover']) {
            return !$game['is_home_team_ball'];
        }
        return $game['is_home_team_ball'];
    }

    function is_goal_to_go($game, $outcome)
    {
        // Is now extra point
        if ($outcome['is_touchdown']) {
            return false;
        }
        if ($outcome['is_kick_good']) {
            return false;
        }
        // Is now kickoff
        if ($game['is_extra_point_attempt'])  {
            return false;
        }
        if ($outcome['is_safety']) {
            return false;
        }
        // First down
        if ($outcome['yards'] >= $game['yards_to_first_down']) {
            // Is to goal first down
            if ($this->ball_on_yard_line($game, $outcome) + 10 > 100) {
                return true;
            }
        }
        return false;
    }

}
?>