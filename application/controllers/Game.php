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
        $this->load->view('game', $data);
        $this->load->view('game_script', $data);
        $this->load->view('templates/footer', $data);
    }

    public function get_game_info($game_id, $last_play_id)
    {
        $data['game'] = $this->game_model->get_game($game_id);
        $data['last_play'] = $this->game_model->get_game_last_play($game_id, $last_play_id);
        echo json_encode($data);
    }

    public function offense_play_select($game_id, $play_id)
    {
        // Search for pending game history
        $game = $this->game_model->get_game($game_id);
        $pending_history = $this->play_model->get_pending_game_history_for_offense($game_id);

        // Use open game, or start new one
        $ready_for_play = false;
        if ($pending_history) {
            $this->play_model->update_game_history_for_offense($game_id, $game, $pending_history['id']);
            $ready_for_play = true;
        }
        else {
            $this->play_model->create_game_history_for_offense($game_id, $game);
        }

        // Return if ready
        return $ready_for_play;
    }
}
