<?php
include_once "Simulation.php";
include_once "SimulationTurnResults.php";
include_once "SimulationGameResults.php";
include_once "SimulationResults.php";
class ManaSimulation extends Simulation
{
	public function __construct($deckString, $numberOfGames = 1, $numberOfTurns = 1)
	{
		parent::__construct($deckString, $numberOfGames, $numberOfTurns);
	}
	
	public function runSimulation()
	{
		$this->appendReport("Start Mana Simulation");
		$this->currentSimulationResults = new SimulationResults();
		for ($i = 0; $i < $this->getNumberOfGames(); $i++)
		{
			$this->playGame($i);
		}
		$this->appendReport("End Mana Simulation");
		$this->reportSimulationSummary();
	}
	
	public function playGame($game)
	{
		$this->appendReportSeparator();
		$this->appendReport("Game: " . ($game + 1));
		$this->appendReportSeparator();
		$this->createDeck();
		$this->createBattlefield();
		$this->createGraveyard();
		$this->createExile();
		$this->currentGameResults = new SimulationGameResults();
		$this->getDeck()->shuffle();
		$this->reportDeck();
		$this->drawHand();
		for ($i = 0; $i < $this->getNumberOfTurns(); $i++)
		{
			if ($this->playTurn($i))
			{
				break;
			}
		}
		$this->appendReport("End Game");
		$this->currentSimulationResults->addGameResults($this->currentGameResults);
		$this->reportGameSummary();
	}
	
	public function playTurn($turn)
	{
		$this->appendReportSeparator();
		$this->appendReport("Turn: " . ($turn + 1));
		$this->appendReportSeparator();
		$this->reportHand();
		$this->reportBattlefield();
		$this->reportGraveyard();
		$this->createManaPool();
		$this->landPlayedThisTurn = false;
		
		$this->currentTurnResults = new SimulationTurnResults();
		
		$this->untap();
		
		$this->upkeep();
		
		// main
		
		// combat
		
		// main
		
		// TODO: Draw on first turn?
		if ($this->drawCard())
		{
			// report lost due to empty library
			$this->currentGameResults->addTurnResults($this->currentTurnResults);
			return true;
		}

		while ($this->playCard())
		{
			// try to play another card
		}
	
		$this->drawMana();
		$this->discard();
		$this->reportManaPool();
		$this->appendReport("End Turn");
		
		$this->currentGameResults->addTurnResults($this->currentTurnResults);
		return false;
	}
	
	private function untap()
	{
		$cards = $this->getBattlefield()->getCards();
		foreach($cards as $card)
		{
			$card->untap();
		}
	}
	
	private function upkeep()
	{
		$cards = $this->getBattlefield()->getCards();
		foreach($cards as $card)
		{
			// check for upkeep
		}
	}
	
	private function drawCard()
	{
		if ($this->getDeck()->getCardCount() == 0)
		{
			return true;
		}
		$card = $this->getHand()->drawCard($this->getDeck());
		$this->appendReport("*** Drew: " . $card->getName());
		return false;
	}
	
	private function playCard()
	{
		$candidate = null;
		$hand = $this->getHand();
		foreach ($hand->getCards() as $card)
		{
			// look at each by type
			switch ($card->getType())
			{
				case CardType::BASIC_LAND:
					if ($this->landPlayedThisTurn == false)
					{
						if ($candidate == null)
						{
							$candidate = $card;
						}
						else
						{
							// compare card to candidate and see which is better
							$manaWithCandidate = $this->getBattlefield()->getAvailableMana();
							$manaWithCard = clone $manaWithCandidate;
							
							// TODO: Which ability to use?; since this is for comparison, just use all I guess
							foreach($candidate->getAbilities() as $ability)
							{
								$manaWithCandidate->applyEffects($ability->getEffects());
							}
							
							foreach($card->getAbilities() as $ability)
							{
								$manaWithCard->applyEffects($ability->getEffects());
							}
							
							if ($manaWithCard->betterThan($manaWithCandidate))
							{
								$candidate = $card;
							}
						}
					}
					break;
				default;
			}
		}
		
		if ($candidate != null)
		{
			$hand->playPermanent($candidate, $this->getBattlefield());
			$this->appendReport("*** Played: " . $candidate->getName());
			// TODO: Worry about other land types
			if ($candidate->getType() == CardType::BASIC_LAND)
			{
				$this->landPlayedThisTurn = true;
			}
			return true;
		}
		
		return false;
	}
	
	private function discard()
	{
		$hand = $this->getHand();
		$cards = $hand->getCards();
		
		// TODO: Worry about effects that extend hand limit
		while ($hand->getCardCount() > 7)
		{
			// try to find best card to discard
			// start with non-land
			// then land
			$candidate = null;
			foreach ($cards as $card)
			{
				// finds the first non-basic land
				if ($card->getType() != CardType::BASIC_LAND)
				{
					$candidate = $card;
					break;
				}
			}
			
			if ($candidate == null)
			{
				// just take the first card
				$candidate = $cards[0];
			}
			
			$this->getGraveyard()->addCard($candidate);
			$hand->removeCard($candidate);
			$this->currentTurnResults->incrementDiscarded();
			$this->appendReport("*** Discard: " . $candidate->getName());
		}
	}
	
	private function drawMana()
	{
		// remember a card can have one or more abilities
		// each ability can have one or more costs and one or more
		// corresponding effects, 
		// to trigger an ability all the costs must be paid
		// and all the effects must be resolved
		
		$cards = $this->getBattlefield()->getCards();
		foreach($cards as $card)
		{
			// look for a produce mana effect
			$playable = true;
			$abilities = $card->getAbilities();
			foreach($abilities as $ability)
			{
				$effects = $ability->getEffects();
				foreach($effects as $effect)
				{
					if (is_a($effect, "ProduceManaEffect"))
					{
						// can all the costs be paid?
						$costs = $ability->getCosts();
						foreach($costs as $cost)
						{
							if (!$this->costCanBePaid($card, $cost))
							{
								$playable = false;
								break;
							}
						}
						
						if ($playable)
						{
							$effects = $ability->getEffects();
							foreach($effects as $effect)
							{
								if (is_a($effect, "ProduceManaEffect"))
								{
									$this->addToManaPool($effect);
								}
							}
						}
						break;
					}
				}
			}
		}
	}
	
	private function costCanBePaid($card, $cost)
	{
		return is_a($cost, "TapCost") && !$card->isTapped();
	}
	
	private function addToManaPool($effect)
	{
		$this->getManaPool()->applyEffect($effect);
	}
	
	private function reportDeck()
	{
		$this->reportCollection($this->getDeck(), "Deck:");
	}
	
	private function reportHand()
	{
		$this->reportCollection($this->getHand(), "Hand:");
	}
	
	private function reportBattlefield()
	{
		$this->reportCollection($this->getBattlefield(), "Battlefield:");
	}
	
	private function reportGraveyard()
	{
		$this->reportCollection($this->getGraveyard(), "Graveyard:");
	}
	
	private function reportCollection($collection, $description)
	{
		$this->appendReport($description);
		$i = 1;
		foreach($collection->getCards() as $card)
		{
			$this->appendReport($i++ . ": " . $card->getName());
		}
	}
	
	private function reportManaPool()
	{
		$manaPool = $this->getManaPool();
		$this->appendReport("Mana Pool:");
		$this->appendReport("Colorless: " . $manaPool->getMana(Color::COLORLESS));
		$this->appendReport("Black: " . $manaPool->getMana(Color::BLACK));
		$this->appendReport("Blue: " . $manaPool->getMana(Color::BLUE));
		$this->appendReport("Green: " . $manaPool->getMana(Color::GREEN));
		$this->appendReport("Red: " . $manaPool->getMana(Color::RED));
		$this->appendReport("White: " . $manaPool->getMana(Color::WHITE));
	}
	
	public function reportGameSummary()
	{
		$this->appendReport("Discards by Turn");
		$this->appendReportSeparator();
		$this->appendReport("Turn\tCards");
		$discards = $this->currentGameResults->getDiscardsByTurn();
		$i = 1;
		foreach($discards as $cards)
		{
			$this->appendReport($i++ . "\t" . $cards);
		}
	}
	
	public function reportSimulationSummary()
	{
		$totalDiscards = array();	// length equal to number of turns
		$gameResults = $this->currentSimulationResults->getGameResults();
		foreach($gameResults as $gameResult)
		{
			$discards = $gameResult->getDiscardsByTurn();
			for ($i = 0; $i < count($discards); $i++)
			{
				if (count($totalDiscards) <= $i)
				{
					array_push($totalDiscards, $discards[$i]);
				}
				else
				{
					$totalDiscards[$i] += $discards[$i];
				}
			}
		}
		
		$this->appendReport("Average Discards by Turn");
		$this->appendReportSeparator();
		$this->appendReport("Turn\tAverage Cards");
		$i = 1;
		foreach($totalDiscards as $discards)
		{
			$this->appendReport($i++ . "\t" . $discards / count($gameResults));
		}
	}
	
	private $landPlayedThisTurn;
	private $currentTurnResults;
	private $currentGameResults;
	private $currentSimulationResults;
}
?>
