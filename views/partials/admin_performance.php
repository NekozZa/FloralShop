<div class="bg-light p-0 flex-fill" style="">
    <nav class='bg-white shadow d-flex align-items-center justify-content-between' style='height: 10%'>
        <span class="ms-3">Performance Dashboard</span>
        <button class="btn btn-outline-danger me-3" onclick="logOut()">Log out</button>
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

                    <p class='m-0 revenue-num' style='font-size: 32px'></p>
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

                    <p class='m-0 product-num' style='font-size: 32px'></p>
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

                    <p class='m-0 staff-num' style='font-size: 32px'></p>
                    <div class='d-flex justify-content-between'>
                        <small class='text-secondary'>Staff</small>
                    </div>
                </div>
            </div>
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

<script>
    const staffNum = document.querySelector('.staff-num')
    const revenueNum = document.querySelector('.revenue-num')
    const productNum = document.querySelector('.product-num')

    window.addEventListener('load', async () => {
        staff = await getStaff()
        staffNum.innerHTML = staff.length

        flowers = await getFlowers()
        productNum.innerHTML = flowers.length

        revenueNum.innerHTML = `$${(await getRevenue()) / 1000}K`
    })

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