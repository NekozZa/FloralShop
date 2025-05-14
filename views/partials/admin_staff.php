<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    table {
        font-family: "Poppins", sans-serif;
    }
</style>

<div class="bg-light p-0 flex-fill content" style="">
    <nav class='bg-white shadow d-flex align-items-center justify-content-between' style='height: 10%'>
        <span class="ms-3">Staff Management</span>
        <button class="btn btn-outline-danger me-3" onclick="logOut()">Log out</button>
    </nav>

    <div class="container p-5" style='height: 90%'>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">email</th>
                    <th scope="col">full_name</th>
                    <th scope="col">phone</th>
                    <th scope="col">position</th>
                    <th scope="col">action</th>
                </tr>
            </thead>

            <tbody>
            </tbody>
        </table>
    </div>
</div>

<script>
    const tbody = document.querySelector('tbody')

    window.addEventListener('load', async () => {
        const staff = await getStaff()
        console.log(staff)
        
        staff.forEach((staffInfo) => {
            tbody.appendChild(createStaff(staffInfo))
        })
    })

    async function getStaff() {
        const res = await fetch('./controller/staff_controller.php', { method: 'GET' })
        const data = await res.json()
        return data.return
    }

    async function removeStaff(staffID, accountID) {
        await removeStaffInfo(staffID)
        await removeStaffAccount(accountID)
    }

    async function removeStaffInfo(staffID) {
        const res = await fetch('./controller/staff_controller.php', { 
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({staff_id: staffID}) 
        })

        const data = await res.json()
        console.log(data.message)

        if (data.code == 0) { document.querySelector(`.staff-${staffID}`).remove() }
    }

    async function removeStaffAccount(accountID) {
        const res = await fetch('./controller/account_controller.php', { 
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({account_id: accountID}) 
        })

        const data = await res.json()
        console.log(data.message)
    }

    function createStaff(info) {
        const tr = document.createElement('tr')
        tr.className = `staff-${info.staff_id}`
        tr.innerHTML = `
            <td>${info.email}</td>
            <td>${info.full_name}</td>
            <td>${info.phone}</td>
            <td>${info.position}</td>
            <td>
                <button class="btn btn-outline-danger" onclick="removeStaff(${info.staff_id}, ${info.account_id})">Delete</button>
            </td>
        `
        return tr
    }
</script>