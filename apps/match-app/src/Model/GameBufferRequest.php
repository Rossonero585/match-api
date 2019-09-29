<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class GameBufferRequest
{

    /**
     * @Assert\NotBlank
     * @Assert\DateTime
     */
    private $date;

    /**
     * @Assert\NotBlank
     */
    private $sport;


    /**
     * @Assert\NotBlank
     */
    private $league;


    /**
     * @Assert\NotBlank
     */
    private $team1;


    /**
     * @Assert\NotBlank
     */
    private $team2;


    /**
     * @Assert\NotBlank
     */
    private $source;

    /**
     * @Assert\NotBlank
     * @Assert\Regex("/^(ру)|(ru)|(en)|(анг)/")
     */
    private $lang;

    /**
     * GameBuffer constructor.
     * @param $date
     * @param $sport
     * @param $league
     * @param $team1
     * @param $team2
     * @param $source
     * @param $lang
     */
    public function __construct($date, $sport, $league, $team1, $team2, $source, $lang)
    {
        $this->date = $date;
        $this->sport = $sport;
        $this->league = $league;
        $this->team1 = $team1;
        $this->team2 = $team2;
        $this->source = $source;
        $this->lang = $lang;
    }


    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getSport()
    {
        return $this->sport;
    }

    /**
     * @param mixed $sport
     */
    public function setSport($sport)
    {
        $this->sport = $sport;
    }

    /**
     * @return mixed
     */
    public function getLeague()
    {
        return $this->league;
    }

    /**
     * @param mixed $league
     */
    public function setLeague($league)
    {
        $this->league = $league;
    }

    /**
     * @return mixed
     */
    public function getTeam1()
    {
        return $this->team1;
    }

    /**
     * @param mixed $team1
     */
    public function setTeam1($team1)
    {
        $this->team1 = $team1;
    }

    /**
     * @return mixed
     */
    public function getTeam2()
    {
        return $this->team2;
    }

    /**
     * @param mixed $team2
     */
    public function setTeam2($team2)
    {
        $this->team2 = $team2;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param mixed $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return mixed
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param mixed $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

}