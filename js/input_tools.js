function DisplayErrorStyle(element) {
    let errorDisplay = document.createElement("div")
    errorDisplay.classList.add("errorDisplay")
    errorDisplay.innerText = element
    return errorDisplay
}



let testF = function (array) {

    if (document.querySelector(".errorDisplay")){
        console.log(document.querySelectorAll(".errorDisplay"))
        document.querySelectorAll(".errorDisplay").forEach(function (el) {
            console.log(el)
            el.parentNode.removeChild(el)
        })
    }

    let error = false

    let user = {}
    array.forEach(function (arr) {
        let nameArr = arr.getAttribute('name')
        if (arr.value.length === 0) {
            error = true

           // arr.after(DisplayErrorStyle(" le champ "+nameArr+" est manquant "))
        }
        if (nameArr === 'email') {
            if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(arr.value))){
                error = true
            }
        }
        user[nameArr] = arr.value
    })

    if (error){
        return alert('error')
    }
    if (error === false){

            return user
    }
}


if (document.querySelector('#val')) {
    document.querySelector('#val').addEventListener('click', function () {
        console.log(testF(document.querySelectorAll(".formu")))
    })

}
