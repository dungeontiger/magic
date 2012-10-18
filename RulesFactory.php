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
include_once "Destroy.php";
include_once "CounterSpell.php";

//TODO: Dual lands are not handled properly, need to look at sub type to determine 'rules'

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
			$costs = $this->createCosts($matches[1]);
			$remainingRule = $matches[2];
		}
		
		if (preg_match("/^$cardName enters the battlefield tapped.$/", $remainingRule))
		{
			//TODO: Are costs possible?
			return new EntersBattlefieldTapped();
		}
		
		$remainingRule = str_replace("{", "", $remainingRule);
		$remainingRule = str_replace("}", "", $remainingRule);
		if (preg_match("/^Add (.*) to your mana pool.$/", $remainingRule, $matches))
		{
			// produces mana of some sort
			if (ManaVector::areValidSymbols($matches[1]))
			{
				// simple mana production
				$ruleObj = new Rule(new ProduceManaEffect($matches[1]), $costs, null, null);
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
		
		// 	As Hallowed Fountain enters the battlefield, you may pay 2 life. If you don't, Hallowed Fountain enters the battlefield tapped.
		if (preg_match("/^As $cardName enters the battlefield, you may pay (.*) life. If you don't, $cardName enters the battlefield tapped.$/", $remainingRule, $matches))
		{
			// choice between entering tapped or paying life.
			$choiceRules = array();
			array_push($choiceRules, new EntersBattlefieldTapped(), new LoseLife($matches[1]));
			$ruleObj = new Rule(new Choice($choiceRules), $costs, null, null);
			$this->ruleCache[$rule] = $ruleObj;
			return $ruleObj;
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

	private function createCosts($costRule)
	{
		$costs = array();
		$costRuleArray = explode(",", $costRule);
		foreach($costRuleArray as $costPiece)
		{
			if (strcmp($costPiece, "{T}") == 0)
			{
				array_push($costs, new TapCost());
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
