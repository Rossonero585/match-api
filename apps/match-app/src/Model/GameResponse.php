<?php


namespace App\Model;


class GameResponse
{
    /**
     * @var string
     */
    private $sport;

    /**
     * @var string
     */
    private $league;

    /**
     * @var string
     */
    private $team1;

    /**
     * @var string
     */
    private $team2;

    /**
     * @var string
     */
    private $date;

    /**
     * @var int
     */
    private $bufferCount;

    /**
     * GameResponse constructor.
     * @param string $sport
     * @param string $league
     * @param string $team1
     * @param string $team2
     * @param string $date
     * @param int $count
     */
    public function __construct($sport, $league, $team1, $team2, $date, int $count)
    {
        $this->sport = $sport;
        $this->league = $league;
        $this->team1 = $team1;
        $this->team2 = $team2;
        $this->date = $date;
        $this->bufferCount = $count;
    }

    /**
     * @return string
     */
    public function getSport(): string
    {
        return $this->sport;
    }

    /**
     * @param string $sport
     */
    public function setSport(string $sport)
    {
        $this->sport = $sport;
    }

    /**
     * @return string
     */
    public function getLeague(): string
    {
        return $this->league;
    }

    /**
     * @param string $league
     */
    public function setLeague(string $league)
    {
        $this->league = $league;
    }

    /**
     * @return string
     */
    public function getTeam1(): string
    {
        return $this->team1;
    }

    /**
     * @param string $team1
     */
    public function setTeam1(string $team1)
    {
        $this->team1 = $team1;
    }

    /**
     * @return string
     */
    public function getTeam2(): string
    {
        return $this->team2;
    }

    /**
     * @param string $team2
     */
    public function setTeam2(string $team2)
    {
        $this->team2 = $team2;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getBufferCount(): int
    {
        return $this->bufferCount;
    }

    /**
     * @param int $bufferCount
     */
    public function setBufferCount(int $bufferCount)
    {
        $this->bufferCount = $bufferCount;
    }

}
