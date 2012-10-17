<?php
include_once "CardFactory.php";

//print "Listing all cards that are understood..." . PHP_EOL;

$factory = new CardFactory();
$files = scandir("cards");
$supportedCastingCost = array();
$supportedRules = array();

if ($files === false)
{
	throw "Failed to scan directory." . PHP_EOL;
}

foreach($files as $file)
{
	try
	{
		if (strlen($file) < 4 || strcmp(substr($file, strlen($file) - 4, 4), ".txt") != 0)
		{
//			print "Skipping $file" . PHP_EOL;
		}
		else
		{
			$card = $factory->createCardFromFile("cards/" . $file);
			if ($card == null)
			{
				print "$file returns null" . PHP_EOL;
			}
			else
			{
				if ($card->isSupportedCastingCost() && $card->isSupportedType())
				{
					array_push($supportedCastingCost, $card);
				}
				
				if ($card->isSupportedRules() && $card->isSupportedCastingCost() && $card->isSupportedType())
				{
					array_push($supportedRules, $card);
				}
			}
		}
	}
	catch(Exception $e)
	{
		print "Exception caught for $file: " . $e->getMessage() . PHP_EOL;
	}
}

// dump both arrays to separate files
dumpArray($supportedCastingCost, "supportedCastingCost.txt");
dumpArray($supportedRules, "supportedRules.txt");
					
function dumpArray($cards, $file)
{
	$output = "";
	foreach($cards as $card)
	{
		$output .= $card->getName() . "\t" . CardType::getString($card->getType()) . PHP_EOL;
	}
	file_put_contents($file, $output);
}
?>
