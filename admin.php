<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" 
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" 
        crossorigin="anonymous"
        rel="stylesheet" 
    >

    <link 
        rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cal+Sans&display=swap');

        body {
            font-family: "Cal Sans", sans-serif;
        }
    </style>
</head>
<body style='height: 100vh'>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="bg-dark p-3" style='width: 9%'>
                <div class='text-light'>
                    ADMIN <i class="bi bi-list"></i>

                    <div class='mt-5'>
                        <div class='d-flex justify-content-between'>
                            <i class="bi bi-bar-chart-line-fill me-1"></i> 
                            Dashboard
                            <i class="bi bi-caret-down-fill ms-1"></i>
                        </div>
                        
                        <div>
                            <ul class='text-secondary' style='list-style: none'>
                                <li>Revenue</li>
                                <li>Top Products</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-light p-0" style='width: 91%'>
                <nav class='bg-white shadow' style='height: 10%'>

                </nav>

                <div class="container p-5" style='height: 90%'>
                    <div class="row h-25">
                        <div class='col-3'>
                            <div class='bg-white shadow h-100 w-100 d-flex flex-column p-3'>
                                <div 
                                    class='border rounded rounded-circle mb-3 p-4 d-flex justify-content-center align-items-center bg-body-secondary' 
                                    style='width: 32px; height: 32px'
                                >
                                    <i class="bi bi-cart4" style='font-size: 20px'></i>
                                </div>

                                <p class='m-0' style='font-size: 32px'>$3.879K</p>
                                <div class='d-flex justify-content-between'>
                                    <small class='text-secondary'>Total revenue</small>
                                    <small class='text-success text-opacity-75'>0.44% <i class="bi bi-arrow-up"></i></small>
                                </div>
                            </div>
                        </div>
                        <div class='col-3'>
                            <div class='bg-white shadow h-100 w-100 d-flex flex-column p-3'>
                                <div 
                                    class='border rounded rounded-circle mb-3 p-4 d-flex justify-content-center align-items-center bg-body-secondary' 
                                    style='width: 32px; height: 32px'
                                >
                                    <i class="bi bi-box-fill" style='font-size: 20px'></i>
                                </div>

                                <p class='m-0' style='font-size: 32px'>1.2K</p>
                                <div class='d-flex justify-content-between'>
                                    <small class='text-secondary'>Total products</small>
                                    <small class='text-success text-opacity-75'>0.44% <i class="bi bi-arrow-up"></i></small>
                                </div>
                            </div>
                        </div>
                        <div class='col-3'>
                            <div class='bg-white shadow h-100 w-100 d-flex flex-column p-3'>
                                <div 
                                    class='border rounded rounded-circle mb-3 p-4 d-flex justify-content-center align-items-center bg-body-secondary' 
                                    style='width: 32px; height: 32px'
                                >
                                    <i class="bi bi-people-fill" style='font-size: 20px'></i>
                                </div>

                                <p class='m-0' style='font-size: 32px'>20</p>
                                <div class='d-flex justify-content-between'>
                                    <small class='text-secondary'>Staff</small>
                                    <small class='text-danger text-opacity-75'>0.44% <i class="bi bi-arrow-down"></i></i></small>
                                </div>
                            </div>
                        </div>
                        <div class='col-3'>
                            <div class='bg-white shadow h-100 w-100 d-flex flex-column p-3'>
                                <div 
                                    class='border rounded rounded-circle mb-3 p-4 d-flex justify-content-center align-items-center bg-body-secondary' 
                                    style='width: 32px; height: 32px'
                                >
                                    <i class="bi bi-cart4" style='font-size: 20px'></i>
                                </div>

                                <p class='m-0' style='font-size: 32px'>$3.879K</p>
                                <div class='d-flex justify-content-between'>
                                    <small class='text-secondary'>Total revenue</small>
                                    <small class='text-success text-opacity-75'>0.44% <i class="bi bi-arrow-up"></i></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row h-75 pt-5">
                        <div class="col-8">
                            <div class="bg-white shadow h-auto w-100 p-4">
                                <canvas class='' id="revenue-chart"></canvas>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="bg-white shadow h-auto w-100 p-4">
                                <canvas class='' id="contribution-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" 
        crossorigin="anonymous">
    </script>

    <script>
        const revenue_chart = document.querySelector('#revenue-chart')
        const contribution_chart = document.querySelector('#contribution-chart')

        new Chart(revenue_chart, {
            type: 'line',
            data: {
                labels: ['2022', '2023', '2024', '2025'],
                datasets: [{
                    label: 'Revenues',
                    data: [65, 59, 80, 81],
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(contribution_chart, {
            type: 'doughnut',
            data: {
                labels: ['Rose', 'Lily', 'Golden Blossom', 'Tao'],
                datasets: [{
                    label: 'Revenues',
                    data: [8, 59, 80, 81],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>