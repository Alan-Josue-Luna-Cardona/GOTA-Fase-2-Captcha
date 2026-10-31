<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (! function_exists('gota_initials')) {
	function gota_initials(?string $name): string
	{
		$name = trim((string) $name);
		if ($name === '') {
			return 'U';
		}

		$words = preg_split('/\s+/', $name, -1, PREG_SPLIT_NO_EMPTY);
		if (count($words) > 1) {
			return strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
		}

		return strtoupper(mb_substr($name, 0, 2));
	}
}
