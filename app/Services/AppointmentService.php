<?php

namespace App\Services;

use App\Models\AppointmentModel;

class AppointmentService {
    protected AppointmentModel $appointmentModel;

    public function __construct() {
        $this->appointmentModel = new AppointmentModel();
    }
}