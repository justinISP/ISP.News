function newCommentsOpenFunction(){

    document.getElementById("newComments").style.display = "block";
    document.getElementById("colClose").style.display = "block";
    document.getElementById("colOpen").style.display = "none";

}

function newCommentsCloseFunction(){

    document.getElementById("newComments").style.display = "none";
    document.getElementById("colClose").style.display = "none";
    document.getElementById("colOpen").style.display = "block";

}

function oldCommentsOpenFunction(){

    document.getElementById("oldComments").style.display = "block";
    document.getElementById("colCloseV").style.display = "block";
    document.getElementById("colOpenV").style.display = "none";

}

function oldCommentsCloseFunction(){

    document.getElementById("oldComments").style.display = "none";
    document.getElementById("colCloseV").style.display = "none";
    document.getElementById("colOpenV").style.display = "block";    

}
