<?php

Class Inflector {

public static function plural($word) {
	$pos	= strlen($word)-1;
	// Check last letter
	switch ($word{$pos}) {
		case 's': 	// Maby already plural
			if ($word{$pos-1} == 's')
				return $word.'es';
			else
				return $word;
		case 'o':	// Check for exceptions
			if ($word == 'kilo' || $word == 'photo' || $word == 'piano' || $word == 'soprano' || $word == 'info')
				break;
			return $word.'es';
		case 'h':	// Check letter before lat
			$letter = $word{$pos-1};
			if ($letter == 's' || $letter == 'c')
				return $word.'es';
			break;
		case 'e':	// Check previous letter
			if ($word{strlen($word)-2} != 'f') {
				// Check for exceptions
				switch ($word) {
					case 'mouse':	return 'mice';
					case 'goose':	return 'geese';
					case 'louse':	return 'lice';
				}
				break;
			}
			$word = substr($word, 0, $pos);
		case 'f':	$word = substr($word, 0, strlen($word)-1).'v';
				return $word.'es';
		case 'x':	// Check for exception
				if ($word == 'ox')
					return 'oxen';
				return $word.'es';
		case 'y':	// Check letter before last
				switch ($word{$pos-1}) {
					case 'a':	
					case 'e':
					case 'i':
					case 'o':
					case 'u':
					case 'y':	break;
					default:	return substr($word, 0, $pos).'ies';
				}
				break;
		default:	// Check for exceptions
				switch ($word) {
					case 'foot':	return 'feet';
					case 'tooth':	return 'teeth';
					case 'man':	return 'men';
					case 'woman':	return 'women';
					case 'child':	return 'children';
					case 'sheep':
					case 'deer':	return $word;
				}
	}
	return $word.'s';
}

/** Method for converting word into singular form */
public static function singular($word) {
	$pos = strlen($word)-1;
	// Check is word can be in plural form
	if ($word{$pos} != 's') 
		// Check for exception word
		switch ($word) {
			case 'mice':	return 'mouse';
			case 'geese':	return 'goose';
			case 'lise':	return 'louse';
			case 'feet':	return 'foot';
			case 'teeth':	return 'tooth';
			case 'men':	return 'man';
			case 'women':	return 'woman';
			case 'children':return 'child';
			case 'oxen':	return 'ox';
			default:	return $word;
		}
	// Check letter before last
	switch ($word{$pos-1}) {
		// Already singular form
		case 's':	return $word;
		case 'e':	// Additinal checking. Needed to find correct forms
				switch ($word{$pos-2}) {
					case 'h':	// Check additional rules
						if ($word{$pos-3} != 's' && $word{$pos-3} != 'c')
							break;
						return substr($word, 0, $pos-1);
					case 'i':	// Remplace 'i' with 'y' and remove last two chars
						return substr($word, 0, $pos-2).'y';
					case 'v':	// Replace 'v' with 'f'
						$word{$pos-2} = 'f';
						if ($word == 'knifes' || $word == 'wifes' || $word == 'lifes')
							break;
					case 'o':	// Need to remove last two chars
					case 'x':	// Remove last two chars
				 		return substr($word, 0, $pos-1);
					case 's':	// Check for letter before s
						if ($word{$pos-3} == 's')
							return substr($word, 0, $pos-1);
				}
	}
	// Usual way - remove last 's' letter
	return substr($word, 0, $pos);
}

public static function pluralize($word, $count)
{
	if($count == 0 OR $count > 1)
	{
		return self::plural($word);
	}
	else
	{
		return $word;
	}
}

}