<?php
namespace App\Controllers;

use App\Models\StatisticsModel;

class StatisticsController {
    private $statisticsModel;

    public function __construct() {
        $this->statisticsModel = new StatisticsModel();
    }

    public function showStatistics() {
        $statistics = $this->statisticsModel->getStatistics();

        require_once '../../../src/Views/admin/statistics.php';
    }

}