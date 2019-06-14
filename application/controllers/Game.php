<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        // Uncomment models after database created
        $this->load->model('main_model', '', TRUE);
        $this->load->model('user_model', '', TRUE);
        $this->load->model('team_model', '', TRUE);
        $this->load->model('game_model', '', TRUE);
        $this->load->model('play_model', '', TRUE);

        if (!$this->session->has_userdata('cookie_id')) {
            $this->session->set_userdata('cookie_id', uniqid());
        }

        $this->main_model->record_request();
    }

    public function index($game_id)
    {
        $data['game'] = $this->game_model->get_game($game_id);
        $data['last_play'] = $this->game_model->get_game_last_play($game_id, 0);
        $data['home_team'] = $this->team_model->get_team($data['game']['home_team_key']);
        $data['away_team'] = $this->team_model->get_team($data['game']['away_team_key']);
        $data['offense_plays'] = $this->game_model->get_offense_plays();
        if ($data['home_team']['cookie_id'] === $this->session->cookie_id) {
            $data['is_home_team'] = true;
        }
        else if ($data['away_team']['cookie_id'] === $this->session->cookie_id) {
            $data['is_home_team'] = false;
        }
        else {
            echo 'You are not playing this game';
            return false;
        }

        // Load view
        $data['page_title'] = 'Game Time';
        $this->load->view('templates/header', $data);
        $this->load->view('scoreboard', $data);
        $this->load->view('game', $data);
        $this->load->view('game_script', $data);
        $this->load->view('templates/footer', $data);
    }

    public function get_game_info($game_id)
    {
        $data['game'] = $this->game_model->get_game($game_id);
        $data['last_play'] = $this->game_model->get_game_last_play($game_id);
        $data['current_play'] = $this->game_model->get_game_current_play($game_id);
        $data['outcome'] = false;
        if ($data['current_play']['offense_play_key'] && !is_null($data['current_play']['is_run_stuff'])) {
            $data['outcome'] = $this->the_football_gods($data['current_play']);
            $this->play_model->apply_outcome_to_game_history($data['current_play']['id'], $data['outcome']['id']);
        }
        echo json_encode($data);
    }

    public function the_football_gods($current_play)
    {
        $possible_outcomes = $this->play_model->get_outcome_by_play_key($current_play['offense_play_key']);
        if (!$possible_outcomes) {
            echo 'Football Gods In Progress';
            die();
        }
        // For now, leave it random
        return $possible_outcomes[array_rand($possible_outcomes)];
    }

    public function offense_play_select($game_id, $play_id)
    {
        // Search for pending game history
        $game = $this->game_model->get_game($game_id);
        $pending_history = $this->play_model->get_pending_game_history_for_offense($game_id);

        // Use open game, or start new one
        $data['ready_for_play'] = false;
        if ($pending_history) {
            $this->play_model->update_game_history_for_offense($game, $pending_history['id'], $play_id);
            $data['ready_for_play'] = true;
        }
        else {
            $this->play_model->create_game_history_for_offense($game, $play_id);
        }

        // Return if ready
        echo api_response($data['ready_for_play']);
    }

    public function defense_play_select($game_id, $is_run_stuff, $is_man, $is_blitz)
    {
        // Search for pending game history
        $game = $this->game_model->get_game($game_id);
        $pending_history = $this->play_model->get_pending_game_history_for_offense($game_id);

        // Use open game, or start new one
        $ready_for_play = false;
        if ($pending_history) {
            $this->play_model->update_game_history_for_defense($game, $pending_history['id'], $is_run_stuff, $is_man, $is_blitz);
            $ready_for_play = true;
        }
        else {
            $this->play_model->create_game_history_for_defense($game, $is_run_stuff, $is_man, $is_blitz);
        }

        // Return if ready
        echo api_response($ready_for_play);
    }
}
