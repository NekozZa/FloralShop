const dropZones = document.querySelectorAll('.drop-zone')
const dropMessage = document.querySelector('.drop-message')


dropZones.forEach((dropZone) => {
    dropZone.ondragover = (e) => {
        e.preventDefault()
        dropZone.classList.add('border-primary')
    }
})


dropZones.forEach((dropZone) => {
    dropZone.ondragleave = (e) => {
        dropZone.classList.remove('border-primary')
    }    
})


function addImage(e, type, shopID) {
    const dropZone = e.target
    const fileInput = dropZone.querySelector('input')

    fileInput.click()
    fileInput.onchange = (e) => {
        upload(e.target.files[0], type, e.target.parentElement, shopID)
    }
}

function dropImage(e, type, shopID) {
    e.preventDefault()
    
    if (e.dataTransfer.items) {
        const items = [...e.dataTransfer.items]
        const item = items[0]

        if (item.kind !== 'file') {
            dropMessage.textContent = "Error: Not a file"
            throw new Error('Not a file')
        }

        if (items.length > 1) {
            dropMessage.textContent = "Error: One file only"
            throw new Error('Multiple files')
        }

        if (item.kind === 'file') {
            const file = item.getAsFile()
            
            upload(file, type, e.target.parentElement, shopID)
        }
    }
}


function upload(file, type, destination, shopID) {
    const fr = new FileReader()

    fr.onload = (e) => {
        destination.innerHTML = ''

        const img = document.createElement('img')
        img.src = e.target.result
        img.className = 'img-fluid w-100'
        img.style.width = '100%'
        destination.appendChild(img)
    }

    fr.readAsDataURL(file)

    const formData = new FormData()
    formData.append('image', file)
    formData.append('shopID', shopID)
    formData.append('type', type)

    fetch("/controller/seller.php", {
        method: "POST",
        body: formData
    })
    .then((res) => res.text())
    .then(result => {
        console.log(result)
    })
}