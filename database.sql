-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2019 at 06:33 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `football`
--

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE IF NOT EXISTS `game` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `home_team_key` int(10) unsigned NOT NULL,
  `away_team_key` int(10) unsigned NOT NULL,
  `home_score` int(10) unsigned NOT NULL,
  `away_score` int(10) unsigned NOT NULL,
  `home_timeouts` int(10) unsigned NOT NULL,
  `away_timeouts` int(10) unsigned NOT NULL,
  `quarter` int(10) unsigned NOT NULL,
  `time` varchar(10) NOT NULL,
  `down` int(10) unsigned NOT NULL,
  `ball_on_yard_line` int(11) NOT NULL,
  `yards_to_goal` int(10) unsigned NOT NULL,
  `is_hometeam_ball` tinyint(1) NOT NULL,
  `is_goal_to_go` tinyint(1) NOT NULL,
  `is_kickoff` tinyint(1) NOT NULL,
  `is_extra_point` tinyint(1) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `game_history`
--

CREATE TABLE IF NOT EXISTS `game_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `play_id` int(10) unsigned NOT NULL,
  `offense_play_key` int(10) unsigned NOT NULL,
  `defense_play_key` int(10) unsigned NOT NULL,
  `home_play_key` int(10) unsigned NOT NULL,
  `away_play_key` int(10) unsigned NOT NULL,
  `home_score` int(10) unsigned NOT NULL,
  `away_score` int(10) unsigned NOT NULL,
  `home_timeouts` int(10) unsigned NOT NULL,
  `away_timeouts` int(10) unsigned NOT NULL,
  `quarter` int(10) unsigned NOT NULL,
  `time` varchar(10) NOT NULL,
  `ball_on_yard_line` int(11) NOT NULL,
  `down` int(10) unsigned NOT NULL,
  `yards_to_goal` int(10) unsigned NOT NULL,
  `is_goal_to_go` tinyint(1) NOT NULL,
  `is_home_team_ball` tinyint(1) NOT NULL,
  `is_kickoff` tinyint(1) NOT NULL,
  `is_extra_point` tinyint(1) NOT NULL,
  `is_touchdown` tinyint(1) NOT NULL,
  `is_defense_touchdown` tinyint(1) NOT NULL,
  `is_extra_point_good` tinyint(1) NOT NULL,
  `is_two_point_conversion_good` tinyint(1) NOT NULL,
  `is_safety` tinyint(1) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_key` int(10) unsigned NOT NULL,
  `game_key` int(10) unsigned NOT NULL,
  `team_name` varchar(64) NOT NULL,
  `username` varchar(64) NOT NULL,
  `color` varchar(8) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `report_count` int(10) unsigned NOT NULL,
  `timestamp` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=181 ;

-- --------------------------------------------------------

--
-- Table structure for table `offense_play`
--

CREATE TABLE IF NOT EXISTS `offense_play` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `is_run` tinyint(1) NOT NULL,
  `is_pass` tinyint(1) NOT NULL,
  `is_kick` tinyint(1) NOT NULL,
  `is_punt` tinyint(1) NOT NULL,
  `is_kickoff` tinyint(1) NOT NULL,
  `is_kneel` tinyint(1) NOT NULL,
  `preview_image` varchar(100) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `offense_play`
--

INSERT INTO `offense_play` (`id`, `name`, `is_run`, `is_pass`, `is_kick`, `is_punt`, `is_kickoff`, `is_kneel`, `preview_image`, `created`, `updated`, `deleted`) VALUES
(1, 'run up the middle', 1, 0, 0, 0, 0, 0, '', '2019-06-04 02:55:11', '2019-06-04 02:55:11', NULL),
(2, 'run toss', 1, 0, 0, 0, 0, 0, '', '2019-06-04 02:55:43', '2019-06-04 02:55:43', NULL),
(3, 'QB Dive', 1, 0, 0, 0, 0, 0, '', '2019-06-04 02:55:43', '2019-06-04 02:55:43', NULL),
(4, 'short pass', 0, 1, 0, 0, 0, 0, '', '2019-06-04 02:56:59', '2019-06-04 02:56:59', NULL),
(5, 'medium pass', 0, 1, 0, 0, 0, 0, '', '2019-06-04 02:56:59', '2019-06-04 02:57:16', NULL),
(6, 'long pass', 0, 1, 0, 0, 0, 0, '', '2019-06-04 02:56:59', '2019-06-04 02:57:21', NULL),
(7, 'screen', 0, 1, 0, 0, 0, 0, '', '2019-06-04 02:58:30', '2019-06-04 02:58:30', NULL),
(8, 'bootleg', 0, 1, 0, 0, 0, 0, '', '2019-06-04 02:58:30', '2019-06-04 02:58:30', NULL),
(9, 'billy billy', 0, 1, 0, 0, 0, 0, '', '2019-06-04 02:58:30', '2019-06-04 02:58:30', NULL),
(10, 'punt', 0, 0, 0, 1, 0, 0, '', '2019-06-04 02:59:55', '2019-06-04 02:59:55', NULL),
(11, 'kick', 0, 0, 1, 0, 0, 0, '', '2019-06-04 02:59:55', '2019-06-04 02:59:55', NULL),
(12, 'kneel', 0, 0, 0, 0, 0, 1, '', '2019-06-04 02:59:55', '2019-06-04 02:59:55', NULL),
(13, 'kickoff touchback', 0, 0, 0, 0, 1, 0, '', '2019-06-04 03:00:59', '2019-06-04 03:00:59', NULL),
(14, 'kickoff short', 0, 0, 0, 0, 1, 0, '', '2019-06-04 03:01:19', '2019-06-04 03:01:19', NULL),
(15, 'onside', 0, 0, 0, 0, 1, 0, '', '2019-06-04 03:01:19', '2019-06-04 03:01:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `outcome`
--

CREATE TABLE IF NOT EXISTS `outcome` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `play_key` int(10) unsigned NOT NULL,
  `is_run_stuff` tinyint(1) NOT NULL,
  `is_man` tinyint(1) NOT NULL,
  `is_blitz` tinyint(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `announcer_text` varchar(1000) NOT NULL,
  `yards` int(11) NOT NULL,
  `likelyhood_based_on_stuff_the_run` int(11) NOT NULL,
  `likelyhood_based_on_play_the_pass` int(11) NOT NULL,
  `likelyhood_based_on_man` int(11) NOT NULL,
  `likelyhood_based_on_zone` int(11) NOT NULL,
  `likelyhood_based_on_blitz` int(11) NOT NULL,
  `likelyhood_based_on_send_4` int(11) NOT NULL,
  `likelyhood_based_on_oline_rating` int(11) NOT NULL,
  `likelyhood_based_on_qb_rating` int(11) NOT NULL,
  `likelyhood_based_on_rb_rating` int(11) NOT NULL,
  `likelyhood_based_on_wr_rating` int(11) NOT NULL,
  `likelyhood_based_on_te_rating` int(11) NOT NULL,
  `likelyhood_based_on_dline_rating` int(11) NOT NULL,
  `likelyhood_based_on_lb_rating` int(11) NOT NULL,
  `likelyhood_based_on_db_rating` int(11) NOT NULL,
  `likelyhood_based_on_kicker_rating` int(11) NOT NULL,
  `likelyhood_based_on_special_offence_rating` int(11) NOT NULL,
  `likelyhood_based_on_special_defense_rating` int(11) NOT NULL,
  `seconds_off_clock_during_play` int(10) NOT NULL,
  `seconds_off_clock_after_play` int(10) NOT NULL,
  `announcer_audio_start` varchar(100) NOT NULL,
  `announcer_audio_end` varchar(100) NOT NULL,
  `animation_a` varchar(100) NOT NULL,
  `animation_b` varchar(100) NOT NULL,
  `game_audio` varchar(100) NOT NULL,
  `in_complete` tinyint(1) NOT NULL,
  `is_incomplete` tinyint(1) NOT NULL,
  `is_interception` tinyint(1) NOT NULL,
  `is_fumble` tinyint(1) NOT NULL,
  `is_turnover` tinyint(1) NOT NULL,
  `is_kick_good` tinyint(1) NOT NULL,
  `is_kick_no_good` tinyint(1) NOT NULL,
  `is_always_td` tinyint(1) NOT NULL,
  `is_always_defense_td` tinyint(1) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE IF NOT EXISTS `request` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_flag` bit(1) NOT NULL,
  `user_key` int(10) unsigned NOT NULL,
  `ip` varchar(100) NOT NULL,
  `api_flag` bit(1) NOT NULL,
  `route_url` varchar(1000) NOT NULL,
  `full_url` varchar(1000) NOT NULL,
  `get_data` text NOT NULL,
  `post_data` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` int(10) unsigned NOT NULL,
  `user_key` int(10) unsigned NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `oline_rating` int(10) unsigned DEFAULT NULL,
  `qb_rating` int(10) unsigned DEFAULT NULL,
  `rb_rating` int(10) unsigned DEFAULT NULL,
  `wr_rating` int(10) unsigned DEFAULT NULL,
  `te_rating` int(10) unsigned DEFAULT NULL,
  `dline_rating` int(10) unsigned DEFAULT NULL,
  `lb_rating` int(10) unsigned DEFAULT NULL,
  `db_rating` int(10) unsigned DEFAULT NULL,
  `kicker_rating` int(10) unsigned DEFAULT NULL,
  `special_rating` int(10) unsigned DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `last_load` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ab_test` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `api_key` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
