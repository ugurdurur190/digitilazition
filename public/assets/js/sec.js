function editVoteManage(){
    document.getElementById('approvalManage').value="Güncelle"
    document.getElementById('approvalManage').removeAttribute('disabled');
    var inputs = document.getElementsByClassName('radio');
    for(var i = 0; i < inputs.length; i++) {
        inputs[i].removeAttribute('disabled');
    }
}


function selectUnit(){
    var d = document.getElementById('units');
    d.disabled = false;
}

function disabledUnit(){
    var d = document.getElementById('units');
    d.disabled = true;
}



function selectAnswerType(){
    var x = document.getElementById("type");
    var y = x.selectedIndex;
    if(x.options[y].value=="radio_opt"){
        document.getElementById("preview").innerHTML = 
        '<input type="radio" name="radio[]" disabled/> '+
        '<input type="text" name="radio[]" style="border:none;" maxlength="50" placeholder="Maksimum 50 karakter..." required /><br/>'+
        '<br/>'+
        '<input type="radio" name="radio[]" disabled/> '+
        '<input type="text" name="radio[]" style="border:none;" maxlength="50" placeholder="Maksimum 50 karakter..." required /><br/>';
        var addOptionRadio = document.getElementById("addOptionRadio").style.display = "";
        var addOptionCheck = document.getElementById("addOptionCheck").style.display = "none";
    }
    else if(x.options[y].value=="check_opt"){
        document.getElementById("preview").innerHTML =
        '<input type="checkBox" disabled > '+
        '<input type="text" name="checkBox[]" style="border:none;" maxlength="50" placeholder="Maksimum 50 karakter..." required /><br/>'+
        '<br/>'+
        '<input type="checkBox" disabled > '+
        '<input type="text" name="checkBox[]" style="border:none;" maxlength="50" placeholder="Maksimum 50 karakter..." required /><br/>';
        var addOptionCheck = document.getElementById("addOptionCheck").style.display = "";
        var addOptionRadio = document.getElementById("addOptionRadio").style.display = "none";
    }
    else if(x.options[y].value=="textfield_s"){
        document.getElementById("preview").innerHTML = 
        "<textarea name='text' id='' cols='30' rows='10' class='form-control' disabled='' placeholder='Buraya bir şeyler yazın...'></textarea>";
        var addOptionRadio = document.getElementById("addOptionRadio").style.display = "none";
        var addOptionCheck = document.getElementById("addOptionCheck").style.display = "none";
    }
   }


   function newRadio(){
    document.getElementById("preview").innerHTML += 
        '<br/>'+
        '<input type="radio" name="radio[]" disabled/>  '+
        '<input type="text" name="radio[]" style="border:none;" maxlength="50" placeholder="Maksimum 50 karakter..." required/><br/>';
   }

   function newCheck(){
    document.getElementById("preview").innerHTML += 
        '<br/>'+
        '<input type="checkBox" disabled/>  '+
        '<input type="text" name="checkBox[]" style="border:none;" maxlength="50" placeholder="Maksimum 50 karakter..." required /><br/>';
   }

   function hiddenRemove(){
    var t = document.getElementById("editFormat").style.display = "";
}