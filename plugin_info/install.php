<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';

function CaveVin_install() {
	$values = array(
				'id' => 'mesVin',
				);			
	$sql = "SHOW TABLES LIKE :id";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = file_get_contents(dirname(__FILE__) . '/install_mesVin.sql');
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
	$sql = "SHOW COLUMNS FROM mesVin LIKE 'Met'";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = "ALTER TABLE `mesVin` ADD `Met` text COLLATE 'utf8_general_ci' NULL;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
	$sql = "SHOW COLUMNS FROM mesVin LIKE 'Ettiquette'";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = "ALTER TABLE `mesVin` ADD `Ettiquette` text COLLATE 'utf8_general_ci' NULL;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
	$sql = "SHOW COLUMNS FROM mesVin LIKE 'Apogee'";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = "ALTER TABLE `mesVin` ADD `Apogee` text COLLATE 'utf8_general_ci' NULL;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
	$sql = "SHOW COLUMNS FROM mesVin LIKE 'Garde'";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = "ALTER TABLE `mesVin` ADD `Garde` text COLLATE 'utf8_general_ci' NULL;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
}

function CaveVin_update() {
	$values = array(
				'id' => 'mesVin',
				);			
	$sql = "SHOW TABLES LIKE :id";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = file_get_contents(dirname(__FILE__) . '/install_mesVin.sql');
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
	$sql = "SHOW COLUMNS FROM mesVin LIKE 'Met'";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = "ALTER TABLE `mesVin` ADD `Met` text COLLATE 'utf8_general_ci' NULL;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
	$sql = "SHOW COLUMNS FROM mesVin LIKE 'Ettiquette'";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = "ALTER TABLE `mesVin` ADD `Ettiquette` text COLLATE 'utf8_general_ci' NULL;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
	$sql = "SHOW COLUMNS FROM mesVin LIKE 'Apogee'";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = "ALTER TABLE `mesVin` ADD `Apogee` text COLLATE 'utf8_general_ci' NULL;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
	$sql = "SHOW COLUMNS FROM mesVin LIKE 'Garde'";
	$mesVin = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW);
	if (!$mesVin) {
		$sql = "ALTER TABLE `mesVin` ADD `Garde` text COLLATE 'utf8_general_ci' NULL;";
		DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
	}
}
?>
