/*
let category = document.querySelectorAll('.insideCategory')

let forSeeResp

let arrayColor = []
arrayColor[0]= document.querySelector('.navCategory :first-child')

category.forEach(function (cat) {


    cat.addEventListener('click', function () {
        document.querySelector('#forQuest').innerHTML = " "
        document.querySelector('.loader').style.display = "block"
        console.log(this)
        if (arrayColor[0]){
          //  arrayColor[0].style.backgroundColor = "#0057ff"
          //  arrayColor[0].style.color = "white"
            arrayColor[0].style.backgroundColor = "white"
            arrayColor[0].style.color = "blue"



        }
      //  this.style.backgroundColor = "white"
      //  this.style.color =  "#0057ff"
          this.style.backgroundColor = "blue"
          this.style.color =  "white"
        arrayColor[0] = this

        let idCat = this.getAttribute('id')
        console.log(idCat)
        let objCat = new FormData()
        objCat.append('idCat', idCat)
        sendForcategory(objCat)

    })
})


const sendForcategory = function (elem) {

    fetch('http://localhost:8888/projet-city/faq.php', {
        method: 'POST',
        headers: new Headers(),
        body: elem
    })

        .then((res) => res.json())

        .then((data) => {
            document.querySelector('.loader').style.display = "none"

            console.log(data)
            for (let i = 0; i < data.length; i++) {
                let insideQuest = document.createElement('div')
                let question = document.createElement('div')
                let response = document.createElement('div')
                forSeeResp = document.createElement('span')
                forSeeResp.classList.add('forSeeResp')
                response.classList.add('hideResp')


                forSeeResp.innerText = "Voir réponse"


                forSeeResp.addEventListener("click", function () {
                    console.log(this)
                    let changeText = this
                    //  console.log(this.parentNode.childNodes[2])
                    let myResp = this.parentNode.childNodes[2]
                    console.log(myResp)
                    //   myResp.style.display = "block"

                   if (myResp.style.display === "block") {
                       myResp.style.display = "none"
                       changeText.innerText = "Voir réponse"

                       console.log("haha")
                    }
                    else{
                        myResp.style.display = "block"
                        console.log("la !")
                        changeText.innerText = "Voir moins"

                    }
                })


                    question.innerText = data[i].qestion
                response.innerText = data[i].response
                document.querySelector('#forQuest').appendChild(insideQuest)

                insideQuest.appendChild(question)
                insideQuest.appendChild(forSeeResp)

                insideQuest.appendChild(response)

                question.classList.add('question')
                response.classList.add('response')

            }


        })

        .catch((data) => {
            alert("un incident s'est produit")
        })

}



*/

let forSee = document.querySelectorAll('.forSeeResp')

forSee.forEach(function (see) {
    see.addEventListener("click", function () {
        console.log(this)
        let changeText = this
        console.log(this.parentNode.childNodes)
        let myResp = this.parentNode.childNodes[5]
        console.log(myResp)

        if (myResp.style.display === "block") {
            myResp.style.display = "none"
            changeText.innerText = "Voir réponse"

            console.log("haha")
        }
        else{
            myResp.style.display = "block"
            console.log("la !")
            changeText.innerText = "Voir moins"
        }
    })
})


let nameCat = document.querySelectorAll('.try article')
console.log(nameCat)



nameCat.forEach(function (name){
    name.addEventListener('click', function () {
        console.log(this.childNodes[1])
        let thisChild = this.parentNode.childNodes[3]
        if (this.parentNode.childNodes[3].style.display === "block") {
            this.parentNode.childNodes[3].style.display = "none"
            this.classList.remove('action')
            this.childNodes[1].innerHTML = '<i class="fas fa-caret-down"></i>'

        }
        else{
            this.parentNode.childNodes[3].style.display = "block"
            console.log(this.parentNode.childNodes[3])
            this.classList.add('action')
            this.childNodes[1].innerHTML = '<i class="fas fa-caret-up"></i>'
            console.log("la !")
        }
    })
})
