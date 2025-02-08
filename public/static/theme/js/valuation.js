function onKeyPress() {
    document.querySelector(".error-hint").classList.add("hide");
}
function validateValuationForm(){
    const phone = document.getElementById("dienthoai").value.replace(/[^0-9]/g, "");
    let t = phone.match(/\d/g);
    if(Array.isArray(t)){
        let result = ((t = t.join("")).startsWith("09") || t.startsWith("08") || t.startsWith("07") || t.startsWith("05") || t.startsWith("03")) && (t.length === 10);
        if(result === false){
            document.querySelector(".error-hint").classList.remove("hide");
        }else{
            document.querySelector(".error-hint").classList.add("hide");
        }
        return result;
    }
    document.querySelector(".error-hint").classList.remove("hide");
    return false;
}
