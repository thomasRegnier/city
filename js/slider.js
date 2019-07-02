let slideIndex = 1;

showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    let  img;
    let slides = document.querySelectorAll(".mySlides");
    let  dots = document.getElementsByClassName("dot");

    if (n > slides.length) {
        slideIndex = 1
    }
    if (n < 1) {
        slideIndex = slides.length
    }
    for (img = 0; img < slides.length; img++) {
        slides[img].style.display = "none";

    }
    for (img = 0; img < dots.length; img++) {
        dots[img].className = dots[img].className.replace(" active", "");
    }
    // console.log(slides[slideIndex-1])
    //  console.log(slideIndex-1)
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
}

let next = document.querySelector('.next')

let prev = document.querySelector('.prev')

next.addEventListener('click', function () {
    plusSlides(1)
})

prev.addEventListener('click', function () {
    plusSlides(-1)

})
//
// setInterval(function () {
//     showSlides(slideIndex += 1);
// },6000)



let dotSpan = document.querySelectorAll('.dot')

dotSpan.forEach(function(item, index) {
    item.addEventListener('click', function () {
        currentSlide(index+1)
    })



})

let seeIndex = document.querySelectorAll('.seeEventIndex')


seeIndex.forEach(function (see) {
    see.addEventListener('click', function () {

        let idForEvent = this.getAttribute('eventId')

        parseInt(idForEvent)
        idForEvent = parseInt(idForEvent)

        let dataForEvent = new FormData()

        dataForEvent.append('id', idForEvent)

        if (isNaN(idForEvent)) {
            alert("non autorisé")
            return
        }
        sendId(dataForEvent)
    })
})
