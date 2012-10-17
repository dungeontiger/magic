<?php
class CounterSpell
{
	static public function ruleMatches($rule)
	{
		// may have a period on the end of the sentence
		$test = str_replace(".", "", $rule);
		return strcasecmp($test, self::ruleText) == 0;
	}
	const ruleText = "counter target spell";
}
?>
