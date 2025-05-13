<?php 
    require_once('../model/Staff.php');

    session_start();
    header('Content-Type: application/json');

    class StaffController {
        function get_staff(){
            $staff_model = new Staff();
            return $staff_model->get_staff();
        }
    }

    $staff_controller = new StaffController();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $staff = $staff_controller->get_staff();
        response(0, 'Get Staff Successfully', $staff);
    }

    function response($code, $message, $data = null) {
        die(json_encode([
            'code' => $code,
            'message' => $message,
            'return' => $data
        ]));
    }
?>