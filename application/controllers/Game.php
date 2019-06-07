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

        if (!$this->session->has_userdata('cookie_id')) {
            $this->session->set_userdata('cookie_id', uniqid());
        }

        $this->main_model->record_request();
    }

    public function index($game_id)
    {
        $data['game'] = $this->game_model->get_game($game_id, $this->session->cookie_id);
        $data['home_team'] = $this->team_model->get_team($data['game']['home_team_key']);
        $data['away_team'] = $this->team_model->get_team($data['game']['away_team_key']);
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
}
