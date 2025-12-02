// JSON BASE A MOSTRAR EN FORMULARIO
let baseJSON = {
    "precio": 0.0,
    "cantidad": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    let JsonString = JSON.stringify(baseJSON, null, 2);
    $('#description').val(JsonString);
}

// CUANDO EL DOCUMENTO ESTÉ LISTO
$(document).ready(function() {
    
    init();
    
    // SE LISTAN TODOS LOS PRODUCTOS AL CARGAR LA PÁGINA
    listarProductos();
    
    // BÚSQUEDA EN TIEMPO REAL (keyup)
    $('#search').keyup(function() {
        let search = $('#search').val();
        if(search) {
            buscarProductos(search);
        } else {
            listarProductos();
        }
    });
    
    // AGREGAR PRODUCTO
    $('#product-form').submit(function(e) {
        e.preventDefault();
        agregarProducto();
    });
    
    // ELIMINAR PRODUCTO (delegación de eventos) unidades
    $(document).on('click', '.product-delete', function() {
        if(confirm('¿De verdad deseas eliminar el Producto?')) {
            let productId = $(this).closest('tr').attr('productId');
            eliminarProducto(productId);
        }
    });
    
});

// LISTAR TODOS LOS PRODUCTOS
function listarProductos() {
    $.ajax({
        url: './backend/product-list.php',
        type: 'GET',
        success: function(response) {
            let productos = JSON.parse(response);
            
            if(Object.keys(productos).length > 0) {
                let template = '';
                
                productos.forEach(producto => {
                    let descripcion = '';
                    descripcion += '<li>precio: ' + producto.precio + '</li>';
                    descripcion += '<li>cantidad: ' + producto.cantidad + '</li>';
                    descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                    descripcion += '<li>marca: ' + producto.marca + '</li>';
                    descripcion += '<li>detalles: ' + producto.detalles + '</li>';
                    
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                });
                
                $('#products').html(template);
            }
        }
    });
}

// BUSCAR PRODUCTOS
function buscarProductos(search) {
    $.ajax({
        url: './backend/product-search.php',
        type: 'GET',
        data: { search: search },
        success: function(response) {
            let productos = JSON.parse(response);
            
            if(Object.keys(productos).length > 0) {
                let template = '';
                let template_bar = '';
                
                productos.forEach(producto => {
                    let descripcion = '';
                    descripcion += '<li>precio: ' + producto.precio + '</li>';
                    descripcion += '<li>cantidad: ' + producto.cantidad + '</li>';
                    descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                    descripcion += '<li>marca: ' + producto.marca + '</li>';
                    descripcion += '<li>detalles: ' + producto.detalles + '</li>';
                    
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                    
                    template_bar += `<li>${producto.nombre}</li>`;
                });
                
                // SE HACE VISIBLE LA BARRA DE ESTADO
                $('#product-result').removeClass('d-none').addClass('d-block');
                // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                $('#container').html(template_bar);
                // SE INSERTA LA PLANTILLA EN LA TABLA
                $('#products').html(template);
            }
        }
    });
}

// AGREGAR PRODUCTO
function agregarProducto() {
    // SE OBTIENE EL JSON DEL FORMULARIO
    let productoJsonString = $('#description').val();
    let finalJSON = JSON.parse(productoJsonString);
    finalJSON['nombre'] = $('#name').val();
    
    // VALIDACIONES
    if(!finalJSON.nombre || finalJSON.nombre.trim() === '' || finalJSON.nombre.length > 100) {
        alert('El nombre es requerido y debe tener máximo 100 caracteres');
        return;
    }
    
    if(!finalJSON.marca || finalJSON.marca.trim() === '') {
        alert('La marca es requerida');
        return;
    }
    
    if(!finalJSON.modelo || finalJSON.modelo.trim() === '' || finalJSON.modelo.length > 25) {
        alert('El modelo es requerido y debe tener máximo 25 caracteres');
        return;
    }
    
    if(finalJSON.precio === undefined || finalJSON.precio === null || parseFloat(finalJSON.precio) <= 99.99) {
        alert('El precio debe ser mayor a 99.99');
        return;
    }
    
    if(finalJSON.detalles && finalJSON.detalles.length > 250) {
        alert('Los detalles deben tener máximo 250 caracteres');
        return;
    }
    
    if(finalJSON.cantidad === undefined || finalJSON.cantidad === null || parseInt(finalJSON.cantidad) < 0) {
        alert('La cantidad deben ser mayor o igual a 0');
        return;
    }
    
    if(finalJSON.imagen && finalJSON.imagen.length > 100) {
        alert('La ruta de la imagen debe tener máximo 100 caracteres');
        return;
    }
    
    productoJsonString = JSON.stringify(finalJSON, null, 2);
    
    $.ajax({
        url: './backend/product-add.php',
        type: 'POST',
        contentType: 'application/json',
        data: productoJsonString,
        success: function(response) {
            let respuesta = JSON.parse(response);
            let template_bar = `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;
            
            // SE HACE VISIBLE LA BARRA DE ESTADO
            $('#product-result').removeClass('d-none').addClass('d-block');
            $('#container').html(template_bar);
            
            // SE LIMPIAN LOS CAMPOS DEL FORMULARIO
            $('#name').val('');
            init();
            
            // SE LISTAN TODOS LOS PRODUCTOS
            listarProductos();
        }
    });
}

// ELIMINAR PRODUCTO
function eliminarProducto(id) {
    $.ajax({
        url: './backend/product-delete.php',
        type: 'GET',
        data: { id: id },
        success: function(response) {
            let respuesta = JSON.parse(response);
            let template_bar = `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;
            
            // SE HACE VISIBLE LA BARRA DE ESTADO
            $('#product-result').removeClass('d-none').addClass('d-block');
            $('#container').html(template_bar);
            
            // SE LISTAN TODOS LOS PRODUCTOS
            listarProductos();
        }
    });
}