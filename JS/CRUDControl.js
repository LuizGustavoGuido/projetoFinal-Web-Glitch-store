function esconderOutrosForm(formPrim){
    var divForms = document.getElementById('divForms');
    for (var i = 0; i<4; i++){
        var formArray = divForms.getElementsByTagName("form")
        if (formArray[i].name == formPrim.name){
            formArray[i].classList.remove('invisible')
            formArray[i].classList.add('visible')
        }else{
            formArray[i].classList.remove('visible')
            formArray[i].classList.add('invisible')
        }
        console.log(formArray[i].className)
    }
}
function updateAttributes(table, attrib){
    var attriboptions = attrib.getElementsByTagName("option")
    if (table.value == "users"){
        attriboptions[0].value = "cod"
        attriboptions[0].innerHTML = "cod"
        attriboptions[1].value = "username"
        attriboptions[1].innerHTML = "username"
        attriboptions[2].value = "email"
        attriboptions[2].innerHTML = "email"
    }else if (table.value == "item"){
        attriboptions[0].value = "id"
        attriboptions[0].innerHTML = "id"
        attriboptions[1].value = "nome"
        attriboptions[1].innerHTML = "nome"
        attriboptions[2].value = "tipoproduto"
        attriboptions[2].innerHTML = "tipoproduto"
        attriboptions[3].value = "categoria"
        attriboptions[3].innerHTML = "categoria"
        attriboptions[4].value = "preco"
        attriboptions[4].innerHTML = "preco"

    }else if (table.value == "pedido"){
        attriboptions[0].value = "id"
        attriboptions[0].innerHTML = "id"
        attriboptions[1].value = "nomedestinatario"
        attriboptions[1].innerHTML = "nomedestinatario"
        attriboptions[2].value = "usercod"
        attriboptions[2].innerHTML = "usercod"

    }else if (table.value == "pedidoitem"){
        attriboptions[0].value = "idpedido"
        attriboptions[0].innerHTML = "idpedido"
        attriboptions[1].value = "iditem"
        attriboptions[1].innerHTML = "iditem"
    }
}
function updateOperators(attrib, operator){
    var operatoroptions = operator.getElementsByTagName("option")
    if (attrib.value == "cod" || attrib.value == "id" || attrib.value == "preco" || attrib.value == "usercod" 
    || attrib.value == "idpedido" || attrib.value == "iditem"){
        operatoroptions[0].value = "="
        operatoroptions[1].value = ">"
        operatoroptions[2].value = "<"
        operatoroptions[3].value = ">="
        operatoroptions[4].value = "<="
        operatoroptions[5].value = null
        for (i=0; i<6; i++){
            operatoroptions[i].innerHTML = operatoroptions[i].value
            if (i<5){
                operatoroptions[i].classList.remove('invisible')
                operatoroptions[i].classList.add('visible')
            }else{
                operatoroptions[i].classList.remove('visible')
                operatoroptions[i].classList.add('invisible')
            }
        }

    }else{
        operatoroptions[0].value = "="
        operatoroptions[1].value = null
        operatoroptions[2].value = null
        operatoroptions[3].value = null
        operatoroptions[4].value = null
        operatoroptions[5].value = "like"
        for (i=0; i<6; i++){
            operatoroptions[i].innerHTML = operatoroptions[i].value
            if (i<5){
                operatoroptions[i].classList.remove('visible')
                operatoroptions[i].classList.add('invisible')
            }else{
                operatoroptions[i].classList.remove('invisible')
                operatoroptions[i].classList.add('visible')
            }
        }
    }
}
