let forConnect = document.querySelector('#validConnect')
let mailForCo  = document.querySelector('#idConnect')
let passwordCo = document.querySelector('#passwordConnect')
let alertMsg = document.querySelector('.forMessage')


//console.log(url)


let inputFormConnect = document.querySelectorAll('.connectForm input')
    inputFormConnect.forEach(function (inputConnect) {
        inputConnect.addEventListener('blur', function () {
            test(inputConnect)
        })
    })




if (document.querySelector('#validConnect')) {

    document.querySelector('#validConnect').addEventListener('click', function () {
        document.querySelector('#validConnect').classList.add('testPul')

        document.querySelector('#validConnect').addEventListener("animationend", function () {
            document.querySelector('#validConnect').classList.remove('testPul')
        })

        error =[]
        inputFormConnect.forEach(function (input) {
            test(input)
        })


        if (error.length > 0) {
            console.log("c est mort")

            return
        }
        else{

            let mailConnect = document.querySelector('#idConnect').value
            let passwordConnect = document.querySelector('#passwordConnect').value

            let objUser = new FormData()
            objUser.append('mail', mailConnect)
            objUser.append('password', passwordConnect)

            connect(objUser)
            disNoneandBlock(document.querySelector('.loader'),document.querySelector('.connectForm'))
        }
    })
}



                const connect = function (el){

                    fetch('./login.php', {
                        method: 'POST',
                        headers: new Headers(),
                        body: el
                    })

                        .then((res) => res.json())
                        .then((data) => {
                            console.log(data)
                            document.querySelector('.loader').style.display = "none"
                            document.querySelector('.connectForm').style.display = "flex"

                            notif(alertMsg,data.type,data.msg)
                            alertMsg.addEventListener("animationend", function () {
                                removeMsg(alertMsg,data.type)
                            })

                            if(data.type === 1) {


                                if (data.user.is_admin == 1){
                                    let forAdmin = document.createElement('a')
                                    forAdmin.setAttribute('href',"./admin/")
                                    forAdmin.innerText = "Admin"
                                    forAdmin.classList.add('admin')
                                    document.querySelector('nav').appendChild(forAdmin)
                                }
                                let forDisco = document.createElement('a')
                                forDisco.setAttribute('href',"index.php?logout")
                                forDisco.classList.add('forDisco')
                                forDisco.innerText = "Deconnexion"
                                document.querySelector('nav').appendChild(forDisco)
                                document.querySelector('.nextConnect').style.display = "flex"
                                disNoneandBlock(document.querySelector('.forDiscoAjax'),document.querySelector('.connectForm'))
                                let nameSession = document.querySelector('.nameSession')
                                nameSession.innerText = data.user.name+" "+data.user.firstname
                                console.log(data.user.is_update)
                                let adressUser = data.user.streetNumber+" "+data.user.street+" "+data.user.zipcode+" "+data.user.city
                                displayInfo(data.user.name, data.user.firstname,adressUser,data.user.mail,data.user.is_update,data.user.phone)
                                if (data.bills) {
                                    if (document.body.clientWidth <= '800') {

                                        let newItem = document.createElement('section')
                                        newItem.classList.add('respBills')
                                        document.querySelector('.containUser').after(newItem)
                                    }

                                        for (let i = 0; i<data.bills.length;i++){
                                        if (document.body.clientWidth <= '800') {

                                            displayResponsBills(data.bills[i].date, data.bills[i].title, data.bills[i].amount,data.bills[i].status, data.bills[i].file)
                                        }
                                        else{
                                            displayBills(data.bills[i].title, data.bills[i].amount, data.bills[i].date, data.bills[i].status, data.bills[i].file, data.bills[i].file)

                                        }

                                    }
                                }
                                else{
                                    console.log(data.msgBills)
                                    forBills.innerText = data.msgBills
                                }
                            }
                        })
                        .catch((data) => {
                            alert("un incident s'est produit 6")
                        })
                }




    let userInfo = document.querySelector('.inInfo')

    let containUser = document.querySelector('.nextConnect')

    const displayInfo = function (nameInfo,firstNameInfo,adressInfo,mailInfo,isUpdate,ph) {
        let infoName  = document.createElement('article')
        let infoFirst = document.createElement('article')
        let infoAdress = document.createElement('article')
        let infoMail = document.createElement('article')
        let phone = document.createElement('article')
        phone.innerText = ph
        infoMail.innerText = mailInfo
        infoAdress.innerText = adressInfo
        infoName.innerText = nameInfo
        infoFirst.innerText = firstNameInfo
        userInfo.appendChild(infoName)
        userInfo.appendChild(infoFirst)
        userInfo.appendChild(infoAdress)
        userInfo.appendChild(infoMail)
        userInfo.appendChild(phone)
        if (isUpdate != 0){
            document.querySelector('.firstMsg').style.display = "none"
            document.querySelector('.forMyButt').style.display = "none"
        }
    }

    let forBills = document.querySelector('.forBills')

    const displayBills = function (name, amount, date, status, dwnl, printB) {
        let lineBills = document.createElement('div')
        lineBills.classList.add('lineBills')
        let nameBills = document.createElement('div')
        forBills.appendChild(lineBills)
        let amountBills = document.createElement('div')

        let dateBills = document.createElement('div')
        let forStatusBills = document.createElement('div')
        let divDown = document.createElement('div')
        let printDiv = document.createElement('div')
        let downloadBills = document.createElement('a')
        let print = document.createElement('a')
        lineBills.appendChild(nameBills)
        lineBills.appendChild(amountBills)
        lineBills.appendChild(dateBills)
        lineBills.appendChild(forStatusBills)
        lineBills.appendChild(divDown)
        divDown.appendChild(downloadBills)
        lineBills.appendChild(printDiv)
        printDiv.appendChild(print)

        nameBills.innerText = name
        nameBills.classList.add('nameBills')
        amountBills.innerText = amount+" €"
        dateBills.innerText = date
        downloadBills.innerHTML = '<i class="fas fa-download"></i>'
        downloadBills.setAttribute('href', "./assets/image/"+dwnl)
        downloadBills.setAttribute('target', "blank")
        print.innerHTML = '<i class="fas fa-file-pdf"></i>'
        print.setAttribute('href', "./assets/image/"+printB)
        print.setAttribute('target', "blank")

        if (status == 0){
            let buttPay = document.createElement('button')
            forStatusBills.appendChild(buttPay)
            buttPay.innerText = "Payer facture"
            buttPay.classList.add('payBills')

        }
        else{
            forStatusBills.innerText = "Payée"
            forStatusBills.classList.add('payed')
        }


    }


    const displayResponsBills = function(date,title,amount,status,file){
    let respInside = document.createElement('div')
        respInside.classList.add('respInside')
    let tResp = document.createElement('div')
        tResp.classList.add('respTitle')
        tResp.innerText = date
        document.querySelector('.respBills').appendChild(respInside)
        respInside.appendChild(tResp)
        let respIn = document.createElement('div')
        respIn.classList.add('respIn')
        respIn.innerHTML = '<article>Intitulé</article><article>'+title+'</article>'
     respInside.appendChild(respIn)
        let respIn2 = document.createElement('div')
        respIn2.classList.add('respIn')
        respIn2.innerHTML = '<article>Montant</article><article>'+amount+'</article>'
        let respIn3 = document.createElement('div')
        respIn3.classList.add('respIn')

        console.log(status)
        console.log(typeof status)
        if (status === '0'){
            respIn3.innerHTML = '<article>Payée</article><article> ❌ </article>'
        }
        else{
            respIn3.innerHTML = '<article>Payée</article><article> ✅ </article>'
        }

        let respIn4 = document.createElement('div')
        respIn4.classList.add('respIn')
        respIn4.innerHTML = '<article>Consulter</article><article><a target="_blank" href="./assets/image/'+file+'"><i class="fas fa-file-pdf"></i></a></article>'
        respInside.appendChild(respIn2)
        respInside.appendChild(respIn3)
        respInside.appendChild(respIn4)

    }






    let validUpdate = document.querySelector('#validInfo')
console.log(validUpdate)

validUpdate.addEventListener('click', function () {
    updateUser()
})

const updateUser = function () {
    fetch('./update-user.php', {
        method: 'GET',
        headers: new Headers(),

    })

        .then((res) => res.json())
        .then((data) => {
            console.log(data)

        })
        .catch((data) => {
            alert("un incident s'est produit update")
        })
}





//
// let createFormData = function (el) {
//
//     let newForm = new FormData()
//     el.forEach(function (e) {
//         newForm.append(e['name'], e.value)
//     })
//     return newForm
//     }
//
//
//      document.querySelector('.testObject')   .addEventListener('click', function () {
//          createFormData(inputFormConnect)
//          for (let [key, value] of createFormData(inputFormConnect)) {
//              console.log(key, ':', value);
//          }
//
//      })




