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

        $this->main_model->record_request();
    }

    public function index($game_id)
    {
        $data['game'] = $this->game_model->get_game($game_id);

        // Load view
        $data['page_title'] = 'Game Time';
        $this->load->view('templates/header', $data);
        $this->load->view('game', $data);
        $this->load->view('templates/footer', $data);
    }
}
