<?php
include_once "Deck.php";
include_once "Hand.php";
include_once "Battlefield.php";
include_once "Graveyard.php";
include_once "Exile.php";
include_once "ManaPool.php";
abstract class Simulation
{
	public function __construct($deckString, $numberOfGames = 1, $numberOfTurns = 1)
	{
		$this->deckString = $deckString;
		$this->numberOfTurns = $numberOfTurns;
		$this->numberOfGames = $numberOfGames;
	}
	
	abstract public function runSimulation();

	public function getReport()
	{
		return $this->report;
	}
	
	public function createDeck()
	{
		$this->deck = new Deck($this->deckString);
	}
	
	public function createBattlefield()
	{
		$this->battlefield = new Battlefield();
	}
	
	public function createGraveyard()
	{
		$this->graveyard = new Graveyard();
	}
	
	public function createExile()
	{
		$this->exile = new Exile();
	}
	
	public function createManaPool()
	{
		$this->manaPool = new ManaPool();
	}
	
	public function drawHand()
	{
		$this->hand = new Hand();
		$this->hand->drawHand($this->deck);
	}
	
	public function getDeck()
	{
		return $this->deck;
	}
	
	public function getHand()
	{
		return $this->hand;
	}
	
	public function getBattlefield()
	{
		return $this->battlefield;
	}
	
	public function getNumberOfTurns()
	{
		return $this->numberOfTurns;
	}
	
	public function getGraveyard()
	{
		return $this->graveyard;
	}
	
	public function getExile()
	{
		return $this->exile;
	}
	
	public function getNumberOfGames()
	{
		return $this->numberOfGames;
	}
	
	public function getManaPool()
	{
		return $this->manaPool;
	}
	
	public function appendReport($line)
	{
		$this->report .= $line . PHP_EOL;
	}
	
	public function appendReportSeparator()
	{
		$this->report .= "====================" . PHP_EOL;
	}
	
	private $deck;
	private $hand;
	private $battlefield;
	private $graveyard;
	private $exile;
	private $deckString;
	private $numberOfTurns;
	private $numberOfGames;
	private $manaPool;
	private $report = "";
}
?>
