<?php

namespace App\Controllers;

require_once '../../../src/Views/admin/statistics.php';

class AdminController {
    public function showStatistics() {
        $statisticsModel = new StatisticsModel();
        $statistics = $statisticsModel->getStatistics();
    
    }
}
