function addselect () {
  
    var div;
    var parentDiv;
    var label;
    var select;
    var optionselected;
    var optionwindows19;
    var optionwindows16;
    var optionwindows10;
    var optiondebian10;
    var optiondebian11;
    var optionubuntu20server;
    var optionubuntu20desktop;

    var div = document.getElementById("operatingsystem").value;
    var parentDiv = document.getElementById("tipo");
    
    if(div == "Windows"){

        $("#tipod").remove();
        $("#elecciond").remove();

        $("#tipou").remove();
        $("#eleccionu").remove();

        var label = document.createElement('label');
        label.setAttribute('for','tipodesistema');
        label.setAttribute('class','form-label');
        label.setAttribute('id','tipow');
        label.innerHTML = "Tipo";
        parentDiv.appendChild(label);

        var select = document.createElement('select');
        select.setAttribute('class','form-select');
        select.setAttribute('aria-label','Default select example');
        select.setAttribute('name','tiposistema');
        select.setAttribute('id','eleccionw');
        parentDiv.appendChild(select);

        var optionselected = document.createElement("option");
        optionselected.setAttribute('selected','selected');
        optionselected.setAttribute('id','option');
        optionselected.value = '';
        optionselected.text = "Selecciona un Tipo";
        select.appendChild(optionselected);
        
        var optionwindows19 = document.createElement("option");
        optionwindows19.value = "WindowsServer2019";
        optionwindows19.text = "Windows Server 2019";
        select.appendChild(optionwindows19);

        var optionwindows16 = document.createElement("option");
        optionwindows16.value = "WindowsServer2016";
        optionwindows16.text = "Windows Server 2016";
        select.appendChild(optionwindows16);

        var optionwindows10 = document.createElement("option");
        optionwindows10.value = "Windows10";
        optionwindows10.text = "Windows 10";
        select.appendChild(optionwindows10);

    } else if (div == "Debian") {
        
        $("#tipow").remove();
        $("#eleccionw").remove();

        $("#tipou").remove();
        $("#eleccionu").remove();

        var label = document.createElement('label');
        label.setAttribute('for','tipodesistema');
        label.setAttribute('class','form-label');
        label.setAttribute('id','tipod');
        label.innerHTML = "Tipo";
        parentDiv.appendChild(label);

        var select = document.createElement('select');
        select.setAttribute('class','form-select');
        select.setAttribute('aria-label','Default select example');
        select.setAttribute('name','tiposistema');
        select.setAttribute('id','elecciond');
        parentDiv.appendChild(select);

        var optionselected = document.createElement("option");
        optionselected.setAttribute('selected','selected');
        optionselected.setAttribute('id','option');
        optionselected.value = '';
        optionselected.text = "Selecciona un Tipo";
        select.appendChild(optionselected);


        var optiondebian10 = document.createElement("option");
        optiondebian10.value = "debian10";
        optiondebian10.text = "Debian 10.6.0";
        select.appendChild(optiondebian10);

        var optiondebian11 = document.createElement("option");
        optiondebian11.value = "debian11";
        optiondebian11.text = "Debian 11.3.0";
        select.appendChild(optiondebian11);

            
    } else {

        $("#tipow").remove();
        $("#eleccionw").remove();

        $("#tipod").remove();
        $("#elecciond").remove();

        var label = document.createElement('label');
        label.setAttribute('for','tipodesistema');
        label.setAttribute('class','form-label');
        label.setAttribute('id','tipou');
        label.innerHTML = "Tipo";
        parentDiv.appendChild(label);

        var select = document.createElement('select');
        select.setAttribute('class','form-select');
        select.setAttribute('aria-label','Default select example');
        select.setAttribute('name','tiposistema');
        select.setAttribute('id','eleccionu');
        parentDiv.appendChild(select);
       
        var optionselected = document.createElement("option");
        optionselected.setAttribute('selected','selected');
        optionselected.setAttribute('id','option');
        optionselected.value = '';
        optionselected.text = "Selecciona un Tipo";
        select.appendChild(optionselected);

        var optionubuntu20server = document.createElement("option");
        optionubuntu20server.value = "ubuntu20server";
        optionubuntu20server.text = "Ubuntu 20.04.1 Server";
        select.appendChild(optionubuntu20server);

        var optionubuntu20desktop = document.createElement("option");
        optionubuntu20desktop.value = "ubuntu20escritorio";
        optionubuntu20desktop.text = "Ubuntu 20.04.1 Escritorio";
        select.appendChild(optionubuntu20desktop);
    }
}