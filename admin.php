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
            <div class="bg-dark p-3" style="width: 10%;">
                <div class='text-light'>
                    ADMIN <i class="bi bi-list"></i>

                    <div class='mt-5'>
                        <div class='d-flex justify-content-start'>
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

            <div class="bg-light p-0" style="width: 90%">
                <nav class='bg-white shadow' style='height: 10%'>

                </nav>

                <div class="container p-5" style='height: 90%'>
                    <div class="row h-25">
                        <div class='col-4'>
                            <div class='bg-white shadow h-100 w-100 d-flex flex-column p-3'>
                                <div 
                                    class='border rounded rounded-circle mb-3 p-4 d-flex justify-content-center align-items-center bg-body-secondary' 
                                    style='width: 32px; height: 32px'
                                >
                                    <i class="bi bi-cart4" style='font-size: 20px'></i>
                                </div>

                                <p class='m-0 revenue-num' style='font-size: 32px'>$3.879K</p>
                                <div class='d-flex justify-content-between'>
                                    <small class='text-secondary'>Total revenue</small>
                                </div>
                            </div>
                        </div>
                        <div class='col-4'>
                            <div class='bg-white shadow h-100 w-100 d-flex flex-column p-3'>
                                <div 
                                    class='border rounded rounded-circle mb-3 p-4 d-flex justify-content-center align-items-center bg-body-secondary' 
                                    style='width: 32px; height: 32px'
                                >
                                    <i class="bi bi-box-fill" style='font-size: 20px'></i>
                                </div>

                                <p class='m-0 product-num' style='font-size: 32px'>1.2K</p>
                                <div class='d-flex justify-content-between'>
                                    <small class='text-secondary'>Total products</small>
                                </div>
                            </div>
                        </div>
                        <div class='col-4'>
                            <div class='bg-white shadow h-100 w-100 d-flex flex-column p-3'>
                                <div 
                                    class='border rounded rounded-circle mb-3 p-4 d-flex justify-content-center align-items-center bg-body-secondary' 
                                    style='width: 32px; height: 32px'
                                >
                                    <i class="bi bi-people-fill" style='font-size: 20px'></i>
                                </div>

                                <p class='m-0 staff-num' style='font-size: 32px'>20</p>
                                <div class='d-flex justify-content-between'>
                                    <small class='text-secondary'>Staff</small>
                                </div>
                            </div>
                        </div>
                        <!-- <div class='col-3'>
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
                                </div>
                            </div>
                        </div> -->
                    </div>

                    <div class="row h-75 pt-5 h-auto">
                        <div class="col-8">
                            <div class="bg-white h-100 shadow w-100 p-4">
                                <canvas class='' id="revenue-chart"></canvas>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="bg-white h-100 shadow w-100 p-4">
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
        const staffNum = document.querySelector('.staff-num')
        const revenueNum = document.querySelector('.revenue-num')
        const productNum = document.querySelector('.product-num')

        window.onload = async () => {
            staff = await getStaff()
            staffNum.innerHTML = staff.length

            flowers = await getFlowers()
            productNum.innerHTML = flowers.length

            revenueNum.innerHTML = `$${(await getRevenue()) / 1000}K`
        }

        async function getFlowers() {
            const res = await fetch('./controller/storage_controller.php', { method: 'GET' })
            const data = await res.json()
            return data.return
        }
        
        async function getStaff() {
            const res = await fetch('./controller/staff_controller.php', { method: 'GET' })
            const data = await res.json()
            return data.return
        }

        async function getRevenue() {
            const res = await fetch('./controller/payment_controller.php', { method: 'GET' })
            const data = await res.json()
            return data.return
        }

        async function getFlowersMostRevenue() {
            const res = await fetch('./controller/payment_controller.php?type=flowers', { method: 'GET' })
            const data = await res.json()
            return data.return
        }

        async function getMonthsRevenue() {
            const res = await fetch('./controller/payment_controller.php?type=months', { method: 'GET' })
            const data = await res.json()
            return data.return
        }
    </script>

    <script>
        const revenue_chart = document.querySelector('#revenue-chart')
        const contribution_chart = document.querySelector('#contribution-chart')
        const colors = [
            '#003f88',
            '#0059c1',
            '#007bff',
            '#339dff',
            '#66bfff'
        ]

        async function setDoughnutConfig() {
            const flowers = await getFlowersMostRevenue()
            let names = []
            let revenues = []
            let bgColors = []

            flowers.forEach((flower, index) => {
                names.push(flower.name)
                revenues.push(flower.total_sale)
                bgColors.push(colors[index])
            })

            const config = {
                type: 'doughnut',
                data: {
                    labels: names,
                    datasets: [{
                        label: 'Revenues',
                        data: revenues,
                        backgroundColor: bgColors,
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
            }

            return config
        }

        async function setLineConfig() {
            const monthsRevenue = await getMonthsRevenue()
            console.log(monthsRevenue)

            let months = []
            let sales = []

            monthsRevenue.forEach((month) => {
                months.push(month.month_name)
                sales.push(month.month_sale)
            })

            const config = {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Revenues',
                        data: sales,
                        fill: true,
                        borderColor: '#007bff',
                        pointBackgroundColor: '#0059c1',
                        pointBorderColor: '#ffffff',
                        tension: 0.4
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            }

            return config
        }

        

        setLineConfig()
        .then(res => {
            new Chart(revenue_chart, res);
        })
        .catch(err => {
            console.log(err)
        })

        setDoughnutConfig()
        .then(res => {
            new Chart(contribution_chart, res);
        })
        .catch(err => {
            console.log(err)
        })
    </script>
</body>
</html>