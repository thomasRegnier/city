



    let open = document.querySelector('#open')
    let close = document.querySelector('#close')
    let shadow = document.querySelector('.shadow')
    let menu = document.querySelector('.menu')
    let menuLinks = document.querySelectorAll('.menuDiv')

    const url = "http://localhost:8888/projet-city/"

    console.log(url)

    // open.addEventListener('click', function () {
    //     openMenu()
    //     mooveDiv()
    //
    // })
    //
    // close.addEventListener('click', function () {
    //     closeMenu()
    //     hideDiv()
    //
    // })


    if (shadow) {
        shadow.addEventListener('click', function () {
            closeMenu()
            hideDiv()

        })
    }



    const openMenu = function () {
        open.classList.add('masq')
        close.classList.remove('masq')
        shadow.classList.remove('masq')
        shadow.classList.remove('fadeOut')
        shadow.classList.add('fadeIn')
        menu.classList.remove('closing')
        menu.classList.add('opening')
    }


    const closeMenu = function () {
        open.classList.remove('masq')
        close.classList.add('masq')
        shadow.classList.add('fadeOut')
        shadow.classList.add('masq')
        menu.classList.remove('opening')
        menu.classList.add('closing')

    }



    const mooveDiv = function () {

        for (let j = 0; j<menuLinks.length; j++){
            setTimeout(function () {
                menuLinks[j].classList.add('linkMoove')
                console.log(j)
            }, j * 200)
        }
    }


    const hideDiv = function () {
        for (let i = 0; i<menuLinks.length; i++) {
            menuLinks[i].classList.remove('linkMoove')
            console.log(menuLinks[i])

        }
    }



    let history = document.querySelector('#moreHistory')




    if (history) {
        history.addEventListener('click', function () {
            seeMoreHistory()
        })
    }




    const seeMoreHistory = function () {

        fetch('./history.php', {
            method: 'POST',
            headers: new Headers(),
        })

            .then((res) => res.json())
            .then((data) => {
                console.log(data)
                for (let i= 0 ; i < data.length ; i++){

                    let  id_story = data[i].id
                    let tit_story = data[i].image
                    let dsc_story = data[i].content
                    historyDisplay(id_story, tit_story, dsc_story)
                }
            })

            .catch((data) =>{
                alert("un incident s'est produit")

            })
    }

    let forStories = document.querySelector('#forStories')

    const historyDisplay = function (id, image, content) {
        if (id % 2 === 1){
            let divStory = document.createElement('div')
            divStory.classList.add('forStory')
            let imgStory = document.createElement('img')
            imgStory.setAttribute('src','assets/image/'+image)
            divStory.appendChild(imgStory)
            let articleStory = document.createElement('article')
            divStory.appendChild(articleStory)
            articleStory.innerText = content
            forStories.appendChild(divStory)
            imgStory.classList.add('imgInfos')
        }
        else if (id % 2 === 0){
            let divStory = document.createElement('div')
            divStory.classList.add('forStory')
            divStory.setAttribute('id', "grey")
            let imgStory = document.createElement('img')
            imgStory.setAttribute('src','assets/image/'+image)
            let articleStory = document.createElement('article')
            divStory.appendChild(articleStory)
            articleStory.innerText = content
            divStory.appendChild(imgStory)
            forStories.appendChild(divStory)
            imgStory.classList.add('imgInfos')

        }
        history.style.display = "none"
    }


    let seeOnMap = document.querySelectorAll('.seeOnMap')

    seeOnMap.forEach(function (seeMap) {

        seeMap.addEventListener('click', function () {
            console.log(this)
            console.log(this.getAttribute('id'))
            let idForMap = this.getAttribute('id')

            console.log(typeof idForMap)
            parseInt(idForMap)
            idForMap = parseInt(idForMap)
            console.log(typeof idForMap)
            let dataForMap = new FormData()

            if (isNaN(idForMap)) {
                alert("non autorisé")
                return
            }

            dataForMap.append('id', idForMap)

            fetch('./services-map.php', {
                method: 'POST',
                headers: new Headers(),
                body: dataForMap
            })

                .then((res) => res.json())

                .then((data) => {
                    console.log(data)

                    if (data.type === 1){
                        alert(data.msg)
                    }
                    else{
                        let color = "#33809F"
                        displayMap(data[2],data[1],data[3],color)
                        initMap(parseFloat(data['lattitude']),parseFloat(data['longitude']),data[1],data[3])
                    }


                })

                .catch((data) => {
                    alert("un incident s'est produit la")
                })

        })

    })

    let body = document.querySelector('body')

    let onMap = document.querySelector('.onMap')

    let insideMap = document.querySelector('.insideOnMap')

    const displayMap = function (image,title,adress,color){
        let insideRight = document.querySelector('.insideRight')
        onMap.classList.add('mooveMap')
        insideMap.classList.add('insideShow')
        document.querySelector('.imgOnMap').setAttribute('src', 'assets/image/'+image)
        document.querySelector('.titleOnMap').innerText = title
        document.querySelector('.adrressOnMap').innerHTML = adress
        document.querySelector('.titleOnMap').style.backgroundColor = color
        document.querySelector('.adrressOnMap').style.color = color
        body.style.overflowY = "hidden"
        document.querySelector('.modal').classList.add('actionModal')

    }



    function initMap(latitude,longitude,titre,adres) {
        var uluru = {lat: latitude, lng: longitude};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 17,
            center: uluru
        });

        var contentString = '<div style="width: 90%;" id="content">'+
            '<h2 style="text-align: center; margin: 0" id="firstHeading" class="firstHeading">'+titre+'</h2>'+
            '<div id="bodyContent">'+
            '<p>'+adres+'</p>'+'<a class="itinerary" target="_blank"  href="https://www.google.com/maps/dir//'+latitude+','+longitude+'">Voir l\'itinéraire</a>'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });


        marker.addListener('click', function() {
            infowindow.open(map, marker);
        });
        infowindow.open(map, marker);

    }


    let closerMap = document.querySelector('.closerOnMap')


    if (closerMap) {
        closerMap.addEventListener('click', function () {
            hideMap()
            document.querySelector('.forMedias').innerHTML = ""
        })
    }


    if (onMap){
        onMap.addEventListener('click', function () {
            hideMap()
            document.querySelector('.forMedias').innerHTML = ""
        })
    }




    const hideMap = function () {
        document.querySelector('.modal').classList.remove('actionModal')
        insideMap.classList.remove('insideShow')
        onMap.classList.remove('mooveMap')
        console.log(this)
        body.style.overflowY = "auto"

    }


     validMail = function(elem, blala, msg, star){
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(elem.value)) {
            msg.innerHTML =""
            star.innerHTML = "<i style='margin-left: 5px' class=\"fas fa-check\"></i>"
            star.style.color = "green"
        }
        else{
            msg.innerText = blala
            star.innerText = " * "
            star.style.color = "red"
            msg.style.color = "red"
        }

    }


     isEmpty = function (elem, blala, msg, star){
        if (elem.value.length === 0){
            msg.innerText = blabla
            star.innerText = " * "
            msg.style.color = "red"
            star.style.color = "red"
        }
        else{
            msg.innerHTML =""
            star.innerHTML = ""
        }
    }

//})



const notif = function (e, type, message) {
    if (type === 0){
        e.innerText = message
        e.classList.add('backRed')
        e.classList.add('msgArrive')
    }
    else{
        e.innerText = message
        e.classList.add('backGreen')
        e.classList.add('msgArrive')
    }
}

const removeMsg = function (e,type) {
    if (type === 0){
        e.classList.remove('backRed')
    }
    else{
        e.classList.remove('backGreen')
    }
    e.innerHTML =""
    e.classList.remove('msgArrive')
}



const disNoneandBlock = function (el, e) {
    el.style.display = "block"
    e.style.display = "none"
}


let error = []

const test = function (el){
    if (el.value.length === 0 || el.value === " "){
        el.parentNode.childNodes[2].innerText = " * "
        el.parentNode.childNodes[4].innerText ="le "+el['name']+" est obligatoire"
        error.push(el['name'])
    }
    else{
        el.parentNode.childNodes[2].innerText = ""
        el.parentNode.childNodes[4].innerText = ""
    }

    if (el['name'] === "email") {
        if (el.value.length > 0) {
            if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(el.value))){
                el.parentNode.childNodes[2].innerText = " * "
                el.parentNode.childNodes[4].innerText = el['name']+" est invalide"
                console.log("invalide")
                error.push("mail")

            }
            else{
                el.parentNode.childNodes[2].innerHTML = "<i style='margin-left: 5px; color: green' class=\"fas fa-check\"></i>"
                el.parentNode.childNodes[4].innerText = ""
            }
        }

    }

    console.log(error)

    return error

}

let ham = document.querySelector('.ham')


console.log(ham)


    ham.addEventListener('click',function () {
        showMyMenu()
    })

    document.querySelector('.newShadow').addEventListener('click', function () {
        showMyMenu()
        ham.classList.remove('active')

    })


    const showMyMenu = function(){

        if (document.querySelector('.newMenu').classList.contains('mooveMenu')) {
            document.querySelector('.newMenu').classList.remove('mooveMenu')
            document.querySelector('.newShadow').classList.remove('mooveShadow')
            hideDiv()
            document.querySelector('body').style.overflowY = "auto"
            document.querySelectorAll('.line').forEach(function (line) {
                line.style.stroke = "black"
            })
        }
        else {
            document.querySelector('.newMenu').classList.add('mooveMenu')
            console.log(document.querySelector('.newShadow'))
            document.querySelector('.newShadow').classList.add('mooveShadow')
            mooveDiv()
            document.querySelector('body').style.overflowY = "hidden"
            document.querySelectorAll('.line').forEach(function (line) {
                line.style.stroke = "white"
            })
        }
    }



    const sendId = function (elem) {

        fetch('./oneEvent.php', {
            method: 'POST',
            headers: new Headers(),
            body: elem
        })
            .then((res) => res.json())

            .then((data) => {
                console.log(data)

                if (data.medias_image) {

                    console.log(data.medias_image)
                    let medias = data.medias_image.split(',')
                    console.log(medias)
                    for (let i = 0; i<medias.length; i++){

                        if (medias[i].indexOf('iframe') == 1) {
                            console.log(medias[i])
                            let video = document.createElement('span')
                            document.querySelector('.forMedias').appendChild(video)
                            video.innerHTML = (medias[i])
                        }
                        else{
                            let img = document.createElement('img')
                            img.setAttribute('src','./assets/image/'+medias[i])
                            document.querySelector('.forMedias').appendChild(img)
                        }
                    }
                }
                if (data.type === 1){
                    alert(data.msg)
                }
                else{
                    let color1 = "#87C5DD"
                    displayMap(data['image'],data['title'],data['content'],color1)
                    let adress = data['streetNumber']+" "+data["street"]+" "+data['zipcode']+" "+data['city']
                    initMap(parseFloat(data['lattitude']),parseFloat(data['longitude']),data['title'],adress)
                }
            })
            .catch((data) => {
                alert("un incident s'est produit oneEvent")
            })
    }
