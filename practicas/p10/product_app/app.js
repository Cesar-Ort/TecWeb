// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "cantidad": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

// FUNCIÓN CALLBACK DE BOTÓN "Buscar"
function buscarProducto(e) {
    e.preventDefault();
    
    console.log('=== INICIANDO BÚSQUEDA ===');

    // SE OBTIENE EL CRITERIO DE BÚSQUEDA
    var search = document.getElementById('search').value;
    console.log('Texto a buscar:', search);

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        console.log('ReadyState:', client.readyState, 'Status:', client.status);
        
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[RESPUESTA DEL SERVIDOR]');
            console.log(client.responseText);
            
            // SE OBTIENE EL ARRAY DE PRODUCTOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);
            console.log('Productos parseados:', productos);
            
            // SE VERIFICA SI HAY PRODUCTOS
            if(Array.isArray(productos) && productos.length > 0) {
                console.log('Se encontraron', productos.length, 'productos');
                // SE CREA LA PLANTILLA PARA TODAS LAS FILAS
                let template = '';
                
                productos.forEach(producto => {
                    // SE CREA LA DESCRIPCIÓN DE CADA PRODUCTO
                    let descripcion = '';
                    descripcion += '<li>precio: '+(producto.precio || 'N/A')+'</li>';
                    descripcion += '<li>cantidad: '+(producto.cantidad || 0)+'</li>';
                    descripcion += '<li>modelo: '+(producto.modelo || 'N/A')+'</li>';
                    descripcion += '<li>marca: '+(producto.marca || 'N/A')+'</li>';
                    descripcion += '<li>detalles: '+(producto.detalles || 'N/A')+'</li>';
                    
                    // SE AGREGA LA FILA A LA PLANTILLA
                    template += `
                        <tr>
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;
                });

                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                document.getElementById("productos").innerHTML = template;
            } else {
                console.log('No se encontraron productos o el array está vacío');
                // NO SE ENCONTRARON PRODUCTOS
                document.getElementById("productos").innerHTML = '<tr><td colspan="3">No se encontraron productos</td></tr>';
            }
        }
    };
    
    console.log('Enviando petición con:', "search="+search);
    client.send("search="+search);
}

// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
function agregarProducto(e) {
    e.preventDefault();

    // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
    var productoJsonString = document.getElementById('description').value;
    // SE CONVIERTE EL JSON DE STRING A OBJETO
    var finalJSON = JSON.parse(productoJsonString);
    // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
    finalJSON['nombre'] = document.getElementById('name').value;
    
    // **VALIDACIONES**
    // Validar nombre
    if(!finalJSON.nombre || finalJSON.nombre.trim() === '' || finalJSON.nombre.length > 100) {
        alert('El nombre es requerido y debe tener máximo 100 caracteres');
        return;
    }
    
    // Validar marca
    if(!finalJSON.marca || finalJSON.marca.trim() === '') {
        alert('La marca es requerida');
        return;
    }
    
    // Validar modelo
    if(!finalJSON.modelo || finalJSON.modelo.trim() === '' || finalJSON.modelo.length > 25) {
        alert('El modelo es requerido y debe tener máximo 25 caracteres');
        return;
    }
    
    // Validar precio
    if(finalJSON.precio === undefined || finalJSON.precio === null || parseFloat(finalJSON.precio) <= 99.99) {
        alert('El precio debe ser mayor a 99.99');
        return;
    }
    
    // Validar detalles
    if(finalJSON.detalles && finalJSON.detalles.length > 250) {
        alert('Los detalles deben tener máximo 250 caracteres');
        return;
    }
    
    // Validar cantidad
    if(finalJSON.cantidad === undefined || finalJSON.cantidad === null || parseInt(finalJSON.cantidad) < 0) {
        alert('La cantidad debe ser mayor o igual a 0');
        return;
    }
    
    // Validar imagen (ruta)
    if(finalJSON.imagen && finalJSON.imagen.length > 100) {
        alert('La ruta de la imagen debe tener máximo 100 caracteres');
        return;
    }

    // SE OBTIENE EL STRING DEL JSON FINAL
    productoJsonString = JSON.stringify(finalJSON,null,2);

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log(client.responseText);
            // SE MUESTRA LA RESPUESTA DEL SERVIDOR
            let respuesta = JSON.parse(client.responseText);
            window.alert(respuesta.status);
        }
    };
    client.send(productoJsonString);
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;

    try{
        objetoAjax = new XMLHttpRequest();
    }catch(err1){
        /**
         * NOTA: Las siguientes formas de crear el objeto ya son obsoletas
         *       pero se comparten por motivos historico-académicos.
         */
        try{
            // IE7 y IE8
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(err2){
            try{
                // IE5 y IE6
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(err3){
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}