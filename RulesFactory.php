<?php
include_once "Rule.php";
include_once "TapCost.php";
include_once "ProduceManaEffect.php"; 
include_once "Keywords.php";

include_once "KeywordRule.php";
include_once "UnsupportedRule.php";
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
		
		// only one character, this is a basic land
		if (strlen($rule) == 1)
		{
			// TODO: rename TapCost to Tap and ProduceManaEffect to ProduceMana
			$ruleObj = new Rule(new ProduceManaEffect($rule), new TapCost(), null, null);
			$this->ruleCache[$rule] = $ruleObj;
			return $ruleObj;
		}
		
		$keywordRules = $this->isAllKeywords($rule);
		if (count($keywordRules) > 0)
		{
			// all keywords
			$this->ruleCache[$rule] = $keywordRules;
			return $keywordRules;
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
		return new UnsupportedRule($rule);
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
