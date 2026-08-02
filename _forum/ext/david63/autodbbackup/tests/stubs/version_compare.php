<?php

function phpbb_version_compare($current, $target, $operator)
{
	return version_compare($current, $target, $operator);
}
