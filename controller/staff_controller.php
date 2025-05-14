<?php 
    require_once('../model/Staff.php');

    session_start();
    header('Content-Type: application/json');

    class StaffController {
        function get_staff(){
            $staff_model = new Staff();
            return $staff_model->get_staff();
        }

         function remove_staff($staff_id){
            $staff_model = new Staff();
            $staff_model->remove_staff($staff_id);
        }
    }

    $staff_controller = new StaffController();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $staff = $staff_controller->get_staff();
        response(0, 'Get Staff Successfully', $staff);
    } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['staff_id'])) {
            response(1, 'No Staff ID');
        }

        $staff_controller->remove_staff($data['staff_id']);
        response(0, 'Delete Staff Successfully');
    }

    function response($code, $message, $data = null) {
        die(json_encode([
            'code' => $code,
            'message' => $message,
            'return' => $data
        ]));
    }
?>