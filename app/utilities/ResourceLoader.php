<?php

class ResourceLoader {
	

	public static function getScripts($vendor=false) {
		$collection = array();
		$scripts = $vendor ? Config::get("resources.vendor_js") : Config::get("resources.js");
		foreach ($scripts as $s) {
			if (!is_array($s)) {
				$collection[] = "<script type='text/javascript' src='".$s."'></script>";
			} else {
				foreach ($s AS $script) {
					$collection[] = "<script type='text/javascript' src='".$script."'></script>";						
				}
			}
		}
		return implode("\n", $collection);
	}

	public static function getCSS($vendor=false) {
		$collection = array();
		$css = $vendor ? Config::get("resources.vendor_css") : Config::get("resources.css");
		foreach ($css as $c) {
			if (!is_array($c)) {
				$collection[] = "<link rel='stylesheet' href='$c' type='text/css' />";
			} else {
				foreach ($c AS $cssFile) {
					$collection[] = "<link rel='stylesheet' href='$cssFile' type='text/css' />";
				}
			}
		}
		return implode("\n", $collection);
	}

}

