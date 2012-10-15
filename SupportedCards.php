<?php
include_once "CardFactory.php";

print "Listing all cards that are understood..." . PHP_EOL;

$factory = new CardFactory();
$files = scandir("cards");
if ($files === false)
{
	throw "Failed to scan directory." . PHP_EOL;
}

$i = 0;
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
				if ($card->isSupported())
				{
					$i++;
					print "$i: " . $card->getName() . PHP_EOL;
				}
			}
		}
	}
	catch(Exception $e)
	{
		print "Exception caught for $file: " . $e->getMessage() . PHP_EOL;
	}
}
?>
