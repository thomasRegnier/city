
let testSector
let alertMessage = document.querySelector('.forMessage')

document.getElementById('sectors').addEventListener('change',function () {
    document.getElementById('choices').innerHTML = " "
    disNoneandBlock(document.querySelector('.loader'),document.querySelector('.tabs-content'))
    recup()
})


const recup = function () {
    testSector = document.getElementById('sectors').value;
    console.log(testSector)
    sendSector(testSector)
}




const sendSector = function (elem) {

    console.log(typeof elem)
    elem = parseInt(elem)
    console.log(typeof elem)

    if (isNaN(elem)){
        disNoneandBlock(document.querySelector('.tabs-content'),document.querySelector('.loader'))
        document.getElementById('forChoices').style.display = "none"
        document.querySelector('.finalSignal').style.display = "none"
        alert('non autorisé')
        return
    }

    if (elem === 0){
        disNoneandBlock(document.querySelector('.tabs-content'),document.querySelector('.loader'))
        document.getElementById('forChoices').style.display = "none"
        document.querySelector('.finalSignal').style.display = "none"
        return
    }


    let dataForSector = new FormData()

    dataForSector.append('id', elem)

    fetch('./contact.php', {
        method: 'POST',
        headers: new Headers(),
        body: dataForSector
    })
        .then((res) => res.json())

        .then((data) => {
            console.log(data)
            if (data.type === 1){
                alert(data.msg)
            }
            if (data.length === 0){
                console.log(" ca foire")
                document.getElementById('forChoices').style.display = "none"
                document.querySelector('.finalSignal').style.display = "none"
            }
            else{
                 document.getElementById('forChoices').style.display = "block"
            }

            disNoneandBlock(document.querySelector('.tabs-content'),document.querySelector('.loader'))

            let optionChoice = document.createElement('option');
            document.getElementById('choices').appendChild(optionChoice)
            optionChoice.text = "Choisir choix"

            for (let a = 0; a<data.length ;a++){
                console.log(data[a])

                let option = document.createElement('option');
                console.log(option)

                let choicesSelect = document.getElementById('choices')
                choicesSelect.appendChild(option)
                option.text = data[a].name
                option.value = data[a].id
                  option.value[0].selected
            }
        })
        .catch((data) => {
            alert("un incident s'est produit")
        })
}



document.getElementById('choices').addEventListener('change', function () {
    console.log("la")
    console.log(document.getElementById('choices').value)

   console.log(Number.isInteger(parseInt(document.getElementById('choices').value)))
    if (Number.isInteger(parseInt(document.getElementById('choices').value)) === false) {
        document.querySelector('.finalSignal').style.display = "none"

    }
    else{
        document.querySelector('.finalSignal').style.display = "block"
    }
})



let finalOk = document.querySelector('#forSignalValid')
finalOk.addEventListener('click', function () {

    error =[]
    sectorForm.forEach(function (form) {
        test(form)
    })


    if (error.length > 0) {
        console.log("c est mort")
        return
    }



    else {
        recupMess()
    }
})


let sectorForm = document.querySelectorAll('.finalSignal input')
console.log(sectorForm)

console.log(document.querySelector('.finalSignal textarea'))

sectorForm = Array.prototype.slice.call(sectorForm)

sectorForm.push(document.querySelector('.finalSignal textarea'))

sectorForm.forEach(function (form) {
    form.addEventListener('blur', function () {
        test(form)
        console.log(erreur)
    })

})

const recupMess = function () {
    disNoneandBlock(document.querySelector('.loader'),document.querySelector('.tabs-content'))
    let choice = document.querySelector('#choices').value
    let mailMess = document.querySelector('#mailMess').value
    let messageSignal = document.querySelector('#messageSignal').value


    console.log(choice)
    console.log(mailMess)
    console.log(messageSignal)

    let withChoice = new FormData
    withChoice.append('choice',choice)
    withChoice.append('mailMess', mailMess)
    withChoice.append('messageSignal',messageSignal)

    document.querySelector('#messageSignal').value = ""

    fetch('./message_sectors_choices.php', {
        method: 'POST',
        headers: new Headers(),
        body: withChoice
    })
        .then((res) => res.json())
        .then((data) => {
            console.log(data)
            disNoneandBlock(document.querySelector('.tabs-content'),document.querySelector('.loader'),)
            notif(alertMessage,data.type,data.msg)
            alertMessage.addEventListener("animationend", function () {
                removeMsg(alertMessage, data.type)
            })

        })
        .catch((data) => {
            alert("un incident s'est produit")
        })
}


let forFirst = document.querySelector('#forProb')
let forSecond = document.querySelector('#forDmdInfo')
let firstForm = document.querySelector('.firstForm')
let secondForm = document.querySelector('.secondForm')



forFirst.addEventListener('click', function () {
    forFirst.classList.add('inFront')
    forSecond.classList.remove('inBack')
    firstForm.classList.remove('disNone')
        secondForm.classList.add('disNone')
})



forSecond.addEventListener('click', function () {
    forSecond.classList.add('inBack')
    forFirst.classList.remove('inFront')
        secondForm.classList.remove('disNone')
        firstForm.classList.add('disNone')
})



const recupInfo = function () {
   let name = document.querySelector('#nameInfo').value
    let firstName = document.querySelector('#surnameInfo').value
    let emailInfo = document.querySelector('#msgMail').value
    let msgInfo = document.querySelector('#messageInfo').value

    let objInfo = new FormData()
    objInfo.append('name', name)
    objInfo.append('firstName', firstName)
    objInfo.append('email', emailInfo)
    objInfo.append('message', msgInfo)


    fetch('./message.php', {
        method: 'POST',
        headers: new Headers(),
        body: objInfo
    })

        .then((res) => res.json())

        .then((data) => {
            document.querySelector('#messageInfo').value = ""

            console.log(data)
            console.log(data.type)
            disNoneandBlock(document.querySelector('.tabs-content'),document.querySelector('.loader'),)
            notif(alertMessage,data.type,data.msg)
            alertMessage.addEventListener("animationend", function () {
                removeMsg(alertMessage, data.type)
            })
        })
        .catch((data) => {
            alert("un incident s'est produit")
        })
}




let testInput = document.querySelectorAll(".secondForm input")


 console.log(testInput)
 console.log(document.querySelector('.secondForm textarea'))

 testInput = Array.prototype.slice.call(testInput)

 testInput.push(document.querySelector('.secondForm textarea'))


console.log(testInput)


testInput.forEach(function (input) {
    input.addEventListener('blur', function () {
        test(input)
        console.log(erreur)
    })
})



document.querySelector('#validInfoMsg').addEventListener('click', function () {

    error =[]
    testInput.forEach(function (input) {
        test(input)
    })


    if (error.length > 0) {
        console.log("c est mort")
        return
    }

    else{
        disNoneandBlock(document.querySelector('.loader'),document.querySelector('.tabs-content'))

        recupInfo()

    }
})

