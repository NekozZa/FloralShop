<?php 
    session_start();
    if(!isset($_SESSION['UserID'])) {
        header('Location: login.php');
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Scan QR to Trigger Event</title>

    <link href="/public/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body class="d-flex justify-content-center align-items-center w-100" style="height: 100vh">
    <div class="d-flex flex-column align-items-center">
        <h2>Scan the QR Code</h2>
        <div id="reader" class="border rounded" style="width: 300px;"></div>
        <p id="result">Waiting for scan...</p>
    </div>

    <style>
        .pop-up-container {
            width: 100vw;
            height: 100%;
            position: fixed;

            top: 0;
            left: 0;

            background-color: rgba(0, 0, 0, 0.3);

            z-index: 500;

            transition: display 0.5s ease
        }

        .pop-up {
            box-sizing: content-box;

            width: 15vw;
            height: 15vh;
            padding: 0.5rem;

            position: relative;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

            border: 1px dashed white;
            border-radius: 12px;

            font-size: 2rem
        }

        .animation {
            animation: fade 2s ease-in-out forwards;
        }

        @keyframes fade {
            0% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }
    </style>

    <div class="pop-up-container" style='display: none'>
        <div class="pop-up" style='opacity: 1'>
            <i class="bi bi-check-circle-fill text-white"></i>
            <h6 class="text-white">Succesful</h6>
        </div>
    </div>
    

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        const server = 'https://23a2-14-186-114-140.ngrok-free.app'
        const popupContainer = document.querySelector('.pop-up-container')
        const popup = document.querySelector('.pop-up')
        const html5QrCode = new Html5Qrcode("reader");
        
        let hasScanned = false

        html5QrCode.start(
        { facingMode: 'environment'}, 
        {
            fps: 10,   
            qrbox: { width: 350, height: 350 }  
        },
        (decodedText, decodedResult) => {
            if (hasScanned) {return}
            hasScanned = true

            document.querySelector('#result').innerHTML = `Has Scanned`

            const data = JSON.parse(decodedText)
            placeOrder(data.address, data.totalAmount, data.paymentMethod, data.shippingType)

            async function placeOrder (address, totalAmount, paymentMethod, shippingType) {
                const orderCreated = await createOrder(address, totalAmount, paymentMethod, shippingType)
                const cartCleared = await deleteCartItems()

                if (!orderCreated) {
                    document.querySelector('#result').innerHTML = `Failed Order`
                }

                if (!cartCleared) {
                    document.querySelector('#result').innerHTML = `Failed deletion`
                }

                popupContainer.style.display = 'block'
                popup.classList.add('animation')

                popup.addEventListener('animationend', () => {
                    popupContainer.style.display = 'none'
                })
            }

            async function createOrder(address, totalAmount, paymentMethod, shippingType) {
                const res = await fetch(`${server}/controller/order.php`, {
                    method: "POST",
                    headers: { "Content-Type": 'application/json' },
                    body: JSON.stringify({
                        address: address, 
                        totalAmount: totalAmount,
                        paymentMethod: paymentMethod,
                        shippingType: shippingType,
                        isPaid: (paymentMethod == 'Bank Transfer') ? 1 : 0
                    })
                })

                const data = await res.json()

                return data.message == 'Successful'
            }

            async function deleteCartItems() {
                const res = await fetch(`${server}/controller/cart.php`, {
                    method: "DELETE"
                })
                
                const data = await res.json()

                return data.message == 'Successful'
            }
        },
        (errorMessage) => {
            // parse error, ignore it.
        })
        .catch((err) => {
        // Start failed, handle it.
        });

        
    </script>
</body>
</html>