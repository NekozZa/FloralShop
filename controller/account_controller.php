<?php 
    require_once('../model/Account.php');

    session_start();
    header('Content-Type: application/json');

    class AccountController {
        function remove_account($account_id){
            $account_model = new Account();
            $account_model->remove_account($account_id);
        }
    }

    $account_controller = new AccountController();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        
    } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['account_id'])) {
            response(1, 'No Account ID');
        }

        $account_controller->remove_account($data['account_id']);
        response(0, 'Delete Account Successfully');
    }

    function response($code, $message, $data = null) {
        die(json_encode([
            'code' => $code,
            'message' => $message,
            'return' => $data
        ]));
    }
?>