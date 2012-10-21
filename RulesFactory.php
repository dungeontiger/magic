<?php
include_once "Rule.php";
include_once "TapCost.php";
include_once "ProduceManaEffect.php"; 
include_once "Keywords.php";

include_once "Choice.php";
include_once "KeywordRule.php";
include_once "UnsupportedRule.php";
include_once "EntersBattlefieldTapped.php";
include_once "LoseLife.php";
include_once "Sacrifice.php";
include_once "SearchForCard.php";
include_once "SacrificeUnless.php";
include_once "EntersBattlefieldTappedUnless.php";

include_once "Destroy.php";
include_once "CounterSpell.php";

class RulesFactory
{
	public function __construct()
	{
		$this->keywords = new Keywords();
	}
	
	public function makeRule($cardName, $rule)
	{
		// quick check for null or an existing rule in the cache
		if ( strlen($rule) == 0 || strcasecmp($rule, "null") == 0)
		{
			return null;
		}
		else if  (array_key_exists($rule, $this->ruleCache))
		{
			// the cache will handle multiple (same line keywords) by mapping an array
			// not a rule object 
			return $this->ruleCache[$rule];
		}
		
		// only one character, this is a basic land the rule has already been taken care of
		if (strlen($rule) == 1)
		{
			return null;
		}
		
		$keywordRules = $this->isAllKeywords($rule);
		if (count($keywordRules) > 0)
		{
			// all keywords
			$this->ruleCache[$rule] = $keywordRules;
			return $keywordRules;
		}

		// look for an activation
		$costs = array();
		$remainingRule = $rule;
		if (preg_match("/^(.*): (.*)$/U", $rule, $matches))
		{
			$costs = $this->createCosts($cardName, $matches[1]);
			$remainingRule = $matches[2];
		}
		
		if (preg_match("/^$cardName enters the battlefield tapped\.$/", $remainingRule))
		{
			$ruleObj = new Rule(new EntersBattlefieldTapped(), $costs, null, null);
			$this->ruleCache[$rule] = $ruleObj;
			return $ruleObj;
		}
		
		$remainingRule = str_replace("{", "", $remainingRule);
		$remainingRule = str_replace("}", "", $remainingRule);
		if (preg_match("/^Add (.*) to your mana pool\.$/", $remainingRule, $matches))
		{
			// produces mana of some sort
			if (ManaVector::areValidSymbols($matches[1]))
			{
				// simple mana production
				$ruleObj = new Rule(new ProduceManaEffect($matches[1]), $costs, null, null);
				$this->ruleCache[$rule] = $ruleObj;
				return $ruleObj;
			}
			
			if (strcasecmp($matches[1], "one mana of any color") == 0)
			{
				$any = array();
				array_push($any, new ProduceManaEffect("B"));
				array_push($any, new ProduceManaEffect("G"));
				array_push($any, new ProduceManaEffect("R"));
				array_push($any, new ProduceManaEffect("U"));
				array_push($any, new ProduceManaEffect("W"));
				$ruleObj = new Rule(new Choice($any), $costs, null, null);
				$this->ruleCache[$rule] = $ruleObj;
				return $ruleObj;
			}
			
			// complex, W or B ....  R, B, or W
			// get individual pieces, first split by ' or ' then by ','
			$choices = explode(" or ", $matches[1]);
			if (count($choices) > 1)
			{
				// only the first one might have , 
				$choices2 = explode(", ", $choices[0]);
				array_push($choices2, $choices[1]);
				$choiceRules = array();
				foreach($choices2 as $choice)
				{
					if (ManaVector::areValidSymbols($choice))
					{
						array_push($choiceRules, new ProduceManaEffect($choice));
					}
					else
					{
						$ruleObj = new UnsupportedRule($remainingRule, $costs); 
						$this->ruleCache[$rule] = $ruleObj;
						return $ruleObj;
					}
				}
				$ruleObj = new Rule(new Choice($choiceRules), $costs, null, null);
				$this->ruleCache[$rule] = $ruleObj;
				return $ruleObj;
			}
		}
		
		// As Hallowed Fountain enters the battlefield, you may pay 2 life. If you don't, Hallowed Fountain enters the battlefield tapped.
		if (preg_match("/^As $cardName enters the battlefield, you may pay (.*) life. If you don't, $cardName enters the battlefield tapped\.$/", $remainingRule, $matches))
		{
			// choice between entering tapped or paying life.
			$choiceRules = array();
			array_push($choiceRules, new EntersBattlefieldTapped(), new LoseLife($matches[1]));
			$ruleObj = new Rule(new Choice($choiceRules), $costs, null, null);
			$this->ruleCache[$rule] = $ruleObj;
			return $ruleObj;
		}
		
		// Search your library for a basic land card and put it onto the battlefield tapped. Then shuffle your library.
		$searchString = "/^Search your library for a (.*) and put it onto the battlefield tapped. Then shuffle your library\.$/U";
		if (preg_match($searchString, $remainingRule, $matches))
		{
			if (strcasecmp($matches[1], "basic land card") == 0)
			{
				$ruleObj = new Rule(new SearchForCard(SearchForCard::LIBRARY, SearchForCard::BASIC_LAND, 1, SearchForCard::BATTLEFIELD_TAPPED, false), $costs, null, null);
				$this->ruleCache[$rule] = $ruleObj;
				return $ruleObj;
			}
		}
		
		// When Transguild Promenade enters the battlefield, sacrifice it unless you pay {1}.
		$searchSting = "/^When $cardName (.*), sacrifice it unless you pay (.*)\.$/U";
		if (preg_match($searchSting, $remainingRule, $matches))
		{
			// TODO: Fix this -1 one thing, bad
			$when = -1;
			if (strcasecmp($matches[1], "enters the battlefield") == 0)
			{
				$when = SacrificeUnless::ENTERS_BATTLEFIELD;
			}
			
			$life = null;
			$mana = null;
			
			$testMana = str_replace("{", "", $matches[2]);
			$testMana = str_replace("}", "", $testMana);
			
			if (ManaVector::areValidSymbols($testMana))
			{
				$mana = new ManaVector($testMana);
			}
			
			if ($when >= 0)
			{
				if ($mana != null)
				{
					$ruleObj = new Rule(new SacrificeUnless($when, $life, $mana), $costs, null, null);
					$this->ruleCache[$rule] = $ruleObj;
					return $ruleObj;
				}
			}
		}
		
		// Hinterland Harbor enters the battlefield tapped unless you control a Forest or an Island.
		if (preg_match("/^$cardName enters the battlefield tapped unless you control (.*)\.$/U", $remainingRule, $matches))
		{
			// get rid of a, or, an and , then split on space and get rid of leading and trailing space
			$unlessOr = array();
			$testPieces = explode(" ", $matches[1]);
			$supported = true;
			foreach($testPieces as $test)
			{
				if (strlen($test) == 0 || strcasecmp("a", $test) == 0 || strcasecmp("an", $test) == 0 || strcasecmp("or", $test) == 0)
				{
					continue;
				}
				else if (strcasecmp("forest", $test) == 0)
				{
					array_push($unlessOr, "forest");
				}
				else if (strcasecmp("mountain", $test) == 0)
				{
					array_push($unlessOr, "mountain");
				}
				else if (strcasecmp("swamp", $test) == 0)
				{
					array_push($unlessOr, "swamp");
				}
				else if (strcasecmp("island", $test) == 0)
				{
					array_push($unlessOr, "island");
				}
				else if (strcasecmp("plains", $test) == 0)
				{
					array_push($unlessOr, "plains");
				}
				else
				{
					$supported = false;
					break;
				}
			}
			
			if ($supported == true)
			{
				$ruleObj = new Rule(new EntersBattlefieldTappedUnless($unlessOr), $costs, null, null);
				$this->ruleCache[$rule] = $ruleObj;
				return $ruleObj;
			}
		}
/*
		else if (CounterSpell::ruleMatches($rule))
		{
			$card->addAbility(new CounterSpell());
		}
		else if (Destroy::ruleMatches($rule))
		{
			$card->addAbility(new Destroy($rule));
		}
*/
		// if we get here it is an unsupported rule
		$ruleObj = new UnsupportedRule($remainingRule, $costs); 
		$this->ruleCache[$rule] = $ruleObj;
		return $ruleObj;
	}
	
	public function makeBasicLandRules($subTypes)
	{
		$rules = array();
		foreach($subTypes as $subType)
		{
			switch ($subType)
			{
				case "Swamp":
					array_push($rules, new Rule(new ProduceManaEffect("B"), new TapCost(), null, null));
					break;
				case "Island":
					array_push($rules, new Rule(new ProduceManaEffect("U"), new TapCost(), null, null));
					break;
				case "Mountain":
					array_push($rules, new Rule(new ProduceManaEffect("R"), new TapCost(), null, null));
					break;
				case "Forest":
					array_push($rules, new Rule(new ProduceManaEffect("G"), new TapCost(), null, null));
					break;
				case "Plains":
					array_push($rules, new Rule(new ProduceManaEffect("W"), new TapCost(), null, null));
					break;
				default:
			}
		}
		return $rules;
	}

	private function createCosts($cardName, $costRule)
	{
		$costs = array();
		$costRuleArray = explode(",", $costRule);
		foreach($costRuleArray as $costPiece)
		{
			$costPiece = ltrim($costPiece);
			$costPiece = rtrim($costPiece);
			$costPiece = str_replace("{", "", $costPiece);
			$costPiece = str_replace("}", "", $costPiece);
			
			if (strcmp($costPiece, "T") == 0)
			{
				array_push($costs, new TapCost());
				continue;
			}
			
			if (preg_match("/^Sacrifice $cardName$/", $costPiece))
			{
				// sacrifice this card
				array_push($costs, new Sacrifice(true));
				continue;
			}
			
			// TODO: this is an unsupported cost
			array_push($costs, $costPiece);
		}
		return $costs;
	}

	private function isAllKeywords($rule)
	{
		$rules = array();
		// keywords can come in as single lines or can come in comma separated
		
		// normalize the string by removing commas
		$test = str_replace(",", "", $rule);

		// go through all the possible key words and remove them from the string if found
		$keywords = $this->keywords->getKeywords();
		$foundKeywords = array();
		foreach($keywords as $key => $value)
		{
			$index = stripos($test, $key);
			if ($index === false)
			{
			}
			else
			{
				array_push($foundKeywords, $value);
				$test = str_ireplace($key, "", $test);
			}
		}
		
		// now remove all spaces
		$test = str_replace(" ", "", $test);
		
		// if test is empty it means we found only keywords, this rule is solved
		if (strlen($test) == 0)
		{
			// apply the keywords we found to the card
			foreach($foundKeywords as $keyword)
			{
				array_push($rules, new KeywordRule($keyword));
			}
		}
		return $rules;
	}
	
	private $ruleCache = array();
	private $keywords;
}
?>
