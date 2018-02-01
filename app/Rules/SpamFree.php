<?php

namespace App\Rules;

use Exception;
use App\Inspections\Spam;

class SpamFree
{
	/**
	 * Determine if the give attribue passes our spam validation
	 * @param  string $attr
	 * @param  string $value
	 * @return bool
	 */
	public function passes($attr, $value)
	{
		try {
			return ! resolve(Spam::class)->detect($value);
		} catch (Exception $e) {
			return false;
		}
	}
}
