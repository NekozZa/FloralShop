<?php 
    require '../vendor/autoload.php';

    use Endroid\QrCode\Color\Color;
    use Endroid\QrCode\Encoding\Encoding;
    use Endroid\QrCode\ErrorCorrectionLevel;
    use Endroid\QrCode\QrCode;
    use Endroid\QrCode\Label\Label;
    use Endroid\QrCode\Logo\Logo;
    use Endroid\QrCode\RoundBlockSizeMode;
    use Endroid\QrCode\Writer\PngWriter;
    use Endroid\QrCode\Writer\ValidationException;

    session_start();
    header('Content-Type: application/json');

    $raw = file_get_contents("php://input");
    $data = json_decode($raw, true); 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($data['address']) && isset($data['totalAmount']) &&
            isset($data['paymentMethod']) && isset($data['shippingType'])) {

            $data = [
                'address' => $data['address'],
                'totalAmount' => $data['totalAmount'],
                'paymentMethod' => $data['paymentMethod'],
                'shippingType' => $data['shippingType']
            ];

            $jsonData = json_encode($data);

            $writer = new PngWriter();

            $qrCode = new QrCode(
                data: $jsonData,
                encoding: new Encoding('UTF-8'),
                errorCorrectionLevel: ErrorCorrectionLevel::Low,
                size: 350,
                margin: 10,
                roundBlockSizeMode: RoundBlockSizeMode::Margin,
                foregroundColor: new Color(0, 0, 0),
                backgroundColor: new Color(255, 255, 255)
            );

            $result = $writer->write($qrCode);
            $dataURI = $result->getDataUri();
            
            echo json_encode([
                'imgURI' => $dataURI,
            ]);
        }
    }
?>