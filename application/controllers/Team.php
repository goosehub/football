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

        $team_point_sum = $oline + $qb + $rb + $wr + $te + $dline + $lb + $db + $kicker + $special;

        if ($team_point_sum > MAX_TEAM_POINTS) {
            echo 'Too many points used. Max is ' . MAX_TEAM_POINTS;
            return false;
        }

        $create_team = $this->team_model->create_team($team_name, $user_key, $image, $oline, $qb, $rb, $wr, $te, $dline, $lb, $db, $kicker, $special);
    }
}
