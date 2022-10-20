main_form = document.getElementById("main-form");
main_form.onclick = function(){
    let code = Math.floor(Math.random()*9999);
    console.log(code);
    document.getElementById("vcode").value = code;
    document.getElementById("vcode_button").click();
    
}
jsfunction = function(){
    document.getElementById("2fac_button").click();
} 