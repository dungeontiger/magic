<?php
include_once "CardFactory.php";
class CardFactoryTest extends PHPUnit_Framework_TestCase
{
	// TODO: somehow test the cache
	
	public function testSwamp()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Swamp");
		$rules = $card->getRules();
		
		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->isASubType("Swamp"));
		assert($card->getCastingCost() == null);
		assert($card->getPower() == null);
		assert($card->getToughness() == null);
		assert($card->getLoyalty() == null);
		assert(count($rules) == 1);
		$ability = $rules[0];
		$costs = $ability->getActivationCosts();
		$effects = $ability->getEffects();
		assert(count($costs) == 1);
		assert(count($effects) == 1);
		assert(is_a($costs[0], "TapCost"));
		assert(is_a($effects[0], "ProduceManaEffect"));
		assert($effects[0]->getProducedMana()->get(Color::BLACK) == 1);
	}
	
	public function testMountain()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Mountain");
		$rules = $card->getRules();
		
		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->isASubType("Mountain"));
		assert(count($rules) == 1);
		$ability = $rules[0];
		$costs = $ability->getActivationCosts();
		$effects = $ability->getEffects();
		assert(count($costs) == 1);
		assert(count($effects) == 1);
		assert(is_a($costs[0], "TapCost"));
		assert(is_a($effects[0], "ProduceManaEffect"));
		assert(strcmp($effects[0]->getProducedMana()->getManaString(), "R") == 0);
	}

	public function testForest()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Forest");
		$rules = $card->getRules();
		
		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->isASubType("Forest"));
		$ability = $rules[0];
		$costs = $ability->getActivationCosts();
		$effects = $ability->getEffects();
		assert(count($costs) == 1);
		assert(count($effects) == 1);
		assert(is_a($costs[0], "TapCost"));
		assert(is_a($effects[0], "ProduceManaEffect"));
		assert(strcmp($effects[0]->getProducedMana()->getManaString(), "G") == 0);
	}

	public function testIsland()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Island");
		$rules = $card->getRules();
		
		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->isASubType("Island"));
		$ability = $rules[0];
		$costs = $ability->getActivationCosts();
		$effects = $ability->getEffects();
		assert(count($costs) == 1);
		assert(count($effects) == 1);
		assert(is_a($costs[0], "TapCost"));
		assert(is_a($effects[0], "ProduceManaEffect"));
		assert(strcmp($effects[0]->getProducedMana()->getManaString(), "U") == 0);
	}

	public function testPlains()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Plains");
		$rules = $card->getRules();

		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->isASubType("Plains"));
		$ability = $rules[0];
		$costs = $ability->getActivationCosts();
		$effects = $ability->getEffects();
		assert(count($costs) == 1);
		assert(count($effects) == 1);
		assert(is_a($costs[0], "TapCost"));
		assert(is_a($effects[0], "ProduceManaEffect"));
		assert(strcmp($effects[0]->getProducedMana()->getManaString(), "W") == 0);
	}

	public function testInvalid()
	{
		// will throw an exception for any unknown or unsupported cards
		$factory = new CardFactory();
		$exception = false;
		try
		{
			$factory->createCard("dungeontiger");
		}
		catch(Exception $e)
		{
			$exception = true;
		}
		assert($exception == true);
	}
	
	public function testSimpleCreature()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Amphin Cutthroat");
		$cost = $card->getCastingCost();
		
		assert($card->getType() == CardType::CREATURE);
		assert($cost->getConvertedTotal() == 4);
		assert($cost->get(Color::BLUE) == 1);
		assert($card->getPower() == 2);
		assert($card->getToughness() == 4);
	}
	
	public function testMoreSimpleCreatures()
	{
		$factory = new CardFactory();
		$factory->createCard("Armored Warhorse");
		$factory->createCard("Bonebreaker Giant");
		$factory->createCard("Coral Merfolk");
		$factory->createCard("Elite Vanguard");
		$factory->createCard("Goblin Piker");
		$factory->createCard("Runeclaw Bear");
		$factory->createCard("Siege Mastodon");
		$factory->createCard("Warpath Ghoul");
	}

	public function testFlyingCreature()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Stormfront Pegasus");
		assert($card->hasKeyword(Keywords::FLYING));
	}
	
	public function testLifelinkCreature()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Ajani's Sunstriker");
		assert($card->hasKeyword(Keywords::LIFELINK));
	}
	
	public function testMultipleKeywordsDifferentLinesCreature()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Aven Squire");
		assert($card->hasKeyword(Keywords::FLYING));
		assert($card->hasKeyword(Keywords::EXALTED));
	}
	
	public function testMultipleKeywordsSameLineCreature()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Archweaver");
		assert($card->hasKeyword(Keywords::REACH));
		assert($card->hasKeyword(Keywords::TRAMPLE));
	}
	
	public function testUnsupported()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Abattoir Ghoul");
		assert(!$card->isSupportedRules());
	}
	
	public function testManaActivation()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Crypt of Agadeem");
		$rules = $card->getRules();
		assert($card->getType() == CardType::LAND);
		assert(!$card->isSupportedRules());
		assert(count($rules) == 3);
		$effects = $rules[0]->getEffects();
		assert(is_a($effects[0], "EntersBattlefieldTapped"));
		assert(is_a($rules[1], "Rule"));
		$costs = $rules[1]->getActivationCosts();
		$effects = $rules[1]->getEffects();
		assert(is_a($costs[0], "TapCost"));
		assert(strcmp($effects[0]->getProducedMana()->getManaString(), "B") == 0);
		assert(is_a($rules[2], "UnsupportedRule"));
//				
//		Codex Shredder
//		Gobbling Ooze
// 		Rakdos Keyrune becomes a creature 
	}
	
	public function testPayOrTap()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Hallowed Fountain");
		$rules = $card->getRules();
		assert($card->getType() == CardType::LAND);
		assert($card->isASubType("Plains"));
		assert($card->isASubType("Island"));
		assert(count($rules) == 3);
		
		// test rule 0 (T:W mana)
		$effects = $rules[0]->getEffects();
		$costs = $rules[0]->getActivationCosts();
		assert(count($effects) == 1);
		assert(strcmp($effects[0]->getProducedMana()->getManaString(), "W") == 0);
		assert(is_a($costs[0], "TapCost"));
		
		// test rule 1 (T:U mana)
		$effects = $rules[1]->getEffects();
		$costs = $rules[1]->getActivationCosts();
		assert(count($effects) == 1);
		assert(strcmp($effects[0]->getProducedMana()->getManaString(), "U") == 0);
		assert(is_a($costs[0], "TapCost"));

		// test rule 2 (choice)
		$effects = $rules[2]->getEffects();
		$costs = $rules[2]->getActivationCosts();
		$choices = $effects[0]->getChoices();
		assert(count($costs) == 0);
		assert(count($effects) == 1);
		assert(is_a($effects[0], "Choice"));
		assert(count($choices) == 2);
		assert(is_a($choices[0], "EntersBattlefieldTapped"));
		assert(is_a($choices[1], "LoseLife"));
		assert($choices[1]->getLife() == 2);
	}
	
	public function testChoiceManaProduction()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Azorius Guildgate");
		$rules = $card->getRules();
		assert($card->getType() == CardType::LAND);
		assert($card->isSupportedRules());
		assert(count($rules) == 2);
		$effects = $rules[0]->getEffects();
		assert(is_a($effects[0], "EntersBattlefieldTapped"));
		assert(is_a($rules[1], "Rule"));
		$costs = $rules[1]->getActivationCosts();
		$effects = $rules[1]->getEffects();
		$effect = $effects[0];
		assert(is_a($costs[0], "TapCost"));
		assert(is_a($effect, "Choice"));
		$choices = $effect->getChoices();
		assert(strcmp($choices[0]->getProducedMana()->getManaString(), "W") == 0);
		assert(strcmp($choices[1]->getProducedMana()->getManaString(), "U") == 0);
	}
	
	public function testSearch()
	{
		// {T}, Sacrifice Evolving Wilds: Search your library for a basic land card and put it onto the battlefield tapped. Then shuffle your library.
		$factory = new CardFactory();
		$card = $factory->createCard("Evolving Wilds");
		$rules = $card->getRules();
		assert(count($rules) == 1);
		$costs = $rules[0]->getActivationCosts();
		assert(count($costs) == 2);
		assert(is_a($costs[0], "TapCost"));
		assert(is_a($costs[1], "Sacrifice"));
		assert($costs[1]->thisCard());
		$effects = $rules[0]->getEffects();
		assert(count($effects) == 1);
		assert($effects[0]->getSearchCollection() == SearchForCard::LIBRARY);
		assert($effects[0]->getSearchFor() == SearchForCard::BASIC_LAND);
		assert($effects[0]->getTargetLocation() == SearchForCard::BATTLEFIELD_TAPPED);
		assert($effects[0]->getNumber() == 1);

	}
	
	public function testSacrificeUnless()
	{
		
		// Transguild Promenade enters the battlefield tapped.
		// When Transguild Promenade enters the battlefield, sacrifice it unless you pay {1}.
		// {T}: Add one mana of any color to your mana pool.
		$factory = new CardFactory();
		$card = $factory->createCard("Transguild Promenade");
		$rules = $card->getRules();
		assert(count($rules) == 3);
		$effects = $rules[0]->getEffects();
		assert(count($effects) == 1);
		assert(is_a($effects[0], "EntersBattlefieldTapped"));
		$effects = $rules[1]->getEffects();
		assert(is_a($effects[0], "SacrificeUnless"));
		assert($effects[0]->getMana()->getManaString() == 1);
		$effects = $rules[2]->getEffects();
		$costs = $rules[2]->getActivationCosts();
		assert(is_a($costs[0], "TapCost"));
		assert(is_a($effects[0], "Choice"));
		$choices = $effects[0]->getChoices();
		assert($choices[0]->getProducedMana()->get(Color::BLACK) == 1);
		assert($choices[1]->getProducedMana()->get(Color::GREEN) == 1);
		assert($choices[2]->getProducedMana()->get(Color::RED) == 1);
		assert($choices[3]->getProducedMana()->get(Color::BLUE) == 1);
		assert($choices[4]->getProducedMana()->get(Color::WHITE) == 1);
	}
	
/*		
	public function testCounterSpell()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Cancel");
		$abilities = $card->getAbilities();
		assert($card->isSupportedRules());
		assert(count($abilities) == 1);
		assert($card->getType() == CardType::INSTANT);
		assert(is_a($abilities[0], "CounterSpell"));
	}
*/	
	// TODO: Destroy, multiple things, all, some creatures, etc...
}
?>
