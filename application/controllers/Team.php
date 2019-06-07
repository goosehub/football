<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team extends CI_Controller {

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

    public function create()
    {
        $team_name = $this->input->post('team_name');
        $user_key = 42;
        $image = '';
        $oline = $this->input->post('oline');
        $qb = $this->input->post('qb');
        $rb = $this->input->post('rb');
        $wr = $this->input->post('wr');
        $te = $this->input->post('te');
        $dline = $this->input->post('dline');
        $lb = $this->input->post('lb');
        $db = $this->input->post('db');
        $kicker = $this->input->post('kicker');
        $special = $this->input->post('special');

        // Enforce maximum rating points
        $team_point_sum = $oline + $qb + $rb + $wr + $te + $dline + $lb + $db + $kicker + $special;
        if ($team_point_sum > MAX_TEAM_RATING_POINTS) {
            echo 'Too many points used. Max is ' . MAX_TEAM_RATING_POINTS;
            return false;
        }

        // Create team
        $team_id = $this->team_model->create_team($team_name, $user_key, $image, $oline, $qb, $rb, $wr, $te, $dline, $lb, $db, $kicker, $special);

        // Search for open game
        $open_game = $this->game_model->get_unstarted_game();

        // Use open game, or start new one
        if ($open_game) {
            $game_id = $open_game['id'];
            $join_game = $this->game_model->join_game($game_id, $team_id);
        }
        else {
            $game_id = $this->game_model->create_game($team_id);
        }

        // Redirect to game
        redirect(base_url() . 'game/' . $game_id, 'refresh');
    }
}
