<?php

class Bootstrap {

	function __construct() {
        $url = trim($_GET['url'] ?? '/', '/');
        $explodedUrl = explode('/', $url);
        $url = '/' . $url;

        $totalToBeChecked = count($explodedUrl);
        foreach ($this->routes as $route) {
            $checked = 0;
            $ids = [];
            foreach ($route['explodeUrl'] as $key => $explodeUrlPart) {
                if (isset($explodedUrl[$key]) && (
                        $explodeUrlPart == $explodedUrl[$key] ||
                        (
                            is_numeric($explodedUrl[$key]) &&
                            preg_match('/^{+.*}$/', trim($explodeUrlPart))
                        )
                    )
                ) {
                    if (is_numeric($explodedUrl[$key])) {
                        $ids[] = $explodedUrl[$key];
                    }
                    $checked = $checked + 1;
                    if ($totalToBeChecked == $checked) {
                        $this->loadPage($route, $ids);
                        break;
                    }
                } else {
                    continue; //start loop again
                }
            }
        }
	}
}