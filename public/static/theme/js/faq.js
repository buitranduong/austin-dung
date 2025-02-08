const faq = document.getElementById("faq");
if(faq){
    const question = faq.getElementsByClassName("question");
    for (let i = 0; i < question.length; i++) {
        question[i].addEventListener("click", function(event) {
            event.preventDefault()
            this.classList.toggle("active");
            const answer = this.nextElementSibling;
            if (answer.style.display === "block") {
                answer.style.display = "none";
            } else {
                answer.style.display = "block";
            }
        });
    }
}

// if ('scrollRestoration' in window.history) {
//     // Back off, browser, I got this...
//     window.history.scrollRestoration = 'manual';
// }
//
// let touchPosAt;
//
// document.body.ontouchstart = function(e){
//     touchPosAt = e.changedTouches[0].clientY;
// }
//
// document.body.ontouchmove = function(e){
//     let newTouchPos = e.changedTouches[0].clientY;
//     if(newTouchPos > touchPosAt) {
//         console.log("finger moving down");
//     }
//     if(newTouchPos < touchPosAt) {
//         console.log("finger moving up");
//     }
// }
