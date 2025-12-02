// Variable para controlar si estamos editando
let edit = false;

// CUANDO EL DOCUMENTO ESTÉ LISTO
$(document).ready(function() {
    
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
    
    // VALIDACIONES EN TIEMPO REAL
    $('#name').keyup(function() {
        validarNombre();
    });
    
    $('#precio').keyup(function() {
        validarPrecio();
    });
    
    $('#cantidad').keyup(function() {
        validarCantidad();
    });
    
    $('#modelo').keyup(function() {
        validarModelo();
    });
    
    $('#marca').keyup(function() {
        validarMarca();
    });
    
    $('#detalles').keyup(function() {
        validarDetalles();
    });
    
    $('#imagen').keyup(function() {
        validarImagen();
    });
    
    // AGREGAR/MODIFICAR PRODUCTO
    $('#product-form').submit(function(e) {
        e.preventDefault();
        
        // Validar todos los campos antes de enviar
        if(!validarTodosCampos()) {
            return;
        }
        
        if(edit) {
            modificarProducto();
        } else {
            agregarProducto();
        }
    });
    
    // EDITAR PRODUCTO (delegación de eventos)
    $(document).on('click', '.product-item', function() {
        let productId = $(this).attr('productId');
        cargarProductoParaEditar(productId);
    });
    
    // ELIMINAR PRODUCTO (delegación de eventos)
    $(document).on('click', '.product-delete', function(e) {
        e.stopPropagation(); // Evitar que se dispare el click de editar
        if(confirm('¿De verdad deseas eliminar el Producto?')) {
            let productId = $(this).closest('tr').attr('productId');
            eliminarProducto(productId);
        }
    });
    
});

// VALIDACIONES
function validarNombre() {
    let nombre = $('#name').val();
    let status = $('#name-status');
    
    if(!nombre || nombre.trim() === '') {
        status.text('El nombre es requerido').removeClass('text-success').addClass('text-danger');
        return false;
    } else if(nombre.length > 100) {
        status.text('Máximo 100 caracteres').removeClass('text-success').addClass('text-danger');
        return false;
    } else {
        // Validar si el nombre ya existe (solo al agregar, no al editar)
        if(!edit) {
            validarNombreExistente(nombre);
        } else {
            status.text('✓ Válido').removeClass('text-danger').addClass('text-success');
        }
        return true;
    }
}

function validarNombreExistente(nombre) {
    $.ajax({
        url: './backend/products/' + nombre,
        type: 'GET',
        success: function(productos) {
            // jQuery ya parseó el JSON automáticamente
            let status = $('#name-status');
            
            // Verificar si existe un producto con ese nombre exacto
            let existe = productos.some(p => p.nombre.toLowerCase() === nombre.toLowerCase());
            
            if(existe) {
                status.text('⚠ Este nombre ya existe').removeClass('text-success').addClass('text-warning');
            } else {
                status.text('✓ Válido').removeClass('text-danger text-warning').addClass('text-success');
            }
        }
    });
}

function validarPrecio() {
    let precio = parseFloat($('#precio').val());
    let status = $('#precio-status');
    
    if(isNaN(precio) || precio <= 99.99) {
        status.text('El precio debe ser mayor a 99.99').removeClass('text-success').addClass('text-danger');
        return false;
    } else {
        status.text('✓ Válido').removeClass('text-danger').addClass('text-success');
        return true;
    }
}

function validarCantidad() {
    let cantidad = parseInt($('#cantidad').val());
    let status = $('#cantidad-status');
    
    if(isNaN(cantidad) || cantidad < 0) {
        status.text('La cantidad debe ser mayor o igual a 0').removeClass('text-success').addClass('text-danger');
        return false;
    } else {
        status.text('✓ Válido').removeClass('text-danger').addClass('text-success');
        return true;
    }
}

function validarModelo() {
    let modelo = $('#modelo').val();
    let status = $('#modelo-status');
    
    if(!modelo || modelo.trim() === '') {
        status.text('El modelo es requerido').removeClass('text-success').addClass('text-danger');
        return false;
    } else if(modelo.length > 25) {
        status.text('Máximo 25 caracteres').removeClass('text-success').addClass('text-danger');
        return false;
    } else {
        status.text('✓ Válido').removeClass('text-danger').addClass('text-success');
        return true;
    }
}

function validarMarca() {
    let marca = $('#marca').val();
    let status = $('#marca-status');
    
    if(!marca || marca.trim() === '') {
        status.text('La marca es requerida').removeClass('text-success').addClass('text-danger');
        return false;
    } else {
        status.text('✓ Válido').removeClass('text-danger').addClass('text-success');
        return true;
    }
}

function validarDetalles() {
    let detalles = $('#detalles').val();
    let status = $('#detalles-status');
    
    if(detalles && detalles.length > 250) {
        status.text('Máximo 250 caracteres').removeClass('text-success').addClass('text-danger');
        return false;
    } else {
        status.text('✓ Válido').removeClass('text-danger').addClass('text-success');
        return true;
    }
}

function validarImagen() {
    let imagen = $('#imagen').val();
    let status = $('#imagen-status');
    
    if(imagen && imagen.length > 100) {
        status.text('Máximo 100 caracteres').removeClass('text-success').addClass('text-danger');
        return false;
    } else {
        status.text('✓ Válido').removeClass('text-danger').addClass('text-success');
        return true;
    }
}

function validarTodosCampos() {
    return validarNombre() && 
           validarPrecio() && 
           validarCantidad() && 
           validarModelo() && 
           validarMarca() && 
           validarDetalles() && 
           validarImagen();
}

// LISTAR TODOS LOS PRODUCTOS
function listarProductos() {
    $.ajax({
        url: './backend/products',
        type: 'GET',
        success: function(productos) {
            // jQuery ya parseó el JSON automáticamente
            
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
                        <tr productId="${producto.id}" class="product-item" style="cursor: pointer;">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                });
                
                $('#products').html(template);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al listar productos:', error);
            console.log('Respuesta del servidor:', xhr.responseText);
        }
    });
}

// BUSCAR PRODUCTOS
function buscarProductos(search) {
    $.ajax({
        url: './backend/products/' + search,
        type: 'GET',
        success: function(productos) {
            // jQuery ya parseó el JSON automáticamente
            
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
                        <tr productId="${producto.id}" class="product-item" style="cursor: pointer;">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger btn-sm">
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
        },
        error: function(xhr, status, error) {
            console.error('Error al buscar productos:', error);
        }
    });
}

// CARGAR PRODUCTO PARA EDITAR
function cargarProductoParaEditar(productId) {
    $.ajax({
        url: './backend/product/' + productId,
        type: 'GET',
        success: function(producto) {
            // jQuery ya parseó el JSON automáticamente
            
            // Cargar datos en el formulario
            $('#productId').val(producto.id);
            $('#name').val(producto.nombre);
            $('#precio').val(producto.precio);
            $('#cantidad').val(producto.cantidad);
            $('#modelo').val(producto.modelo);
            $('#marca').val(producto.marca);
            $('#detalles').val(producto.detalles || '');
            $('#imagen').val(producto.imagen || '');
            
            // Cambiar el texto del botón
            $('.btn-primary').text('Modificar Producto');
            edit = true;
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar producto:', error);
        }
    });
}

// AGREGAR PRODUCTO
function agregarProducto() {
    let producto = {
        nombre: $('#name').val(),
        precio: parseFloat($('#precio').val()),
        cantidad: parseInt($('#cantidad').val()),
        modelo: $('#modelo').val(),
        marca: $('#marca').val(),
        detalles: $('#detalles').val() || 'NA',
        imagen: $('#imagen').val() || 'img/default.png'
    };
    
    $.ajax({
        url: './backend/product',
        type: 'POST',
        contentType: 'application/x-www-form-urlencoded',
        data: producto,
        success: function(respuesta) {
            // jQuery ya parseó el JSON automáticamente
            let template_bar = `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;
            
            // SE HACE VISIBLE LA BARRA DE ESTADO
            $('#product-result').removeClass('d-none').addClass('d-block');
            $('#container').html(template_bar);
            
            // SE LIMPIAN LOS CAMPOS DEL FORMULARIO
            limpiarFormulario();
            
            // SE LISTAN TODOS LOS PRODUCTOS
            listarProductos();
        },
        error: function(xhr, status, error) {
            console.error('Error al agregar producto:', error);
            console.log('Respuesta del servidor:', xhr.responseText);
        }
    });
}

// MODIFICAR PRODUCTO
function modificarProducto() {
    let producto = {
        id: $('#productId').val(),
        nombre: $('#name').val(),
        precio: parseFloat($('#precio').val()),
        cantidad: parseInt($('#cantidad').val()),
        modelo: $('#modelo').val(),
        marca: $('#marca').val(),
        detalles: $('#detalles').val() || 'NA',
        imagen: $('#imagen').val() || 'img/default.png'
    };
    
    $.ajax({
        url: './backend/product',
        type: 'PUT',
        contentType: 'application/x-www-form-urlencoded',
        data: producto,
        success: function(respuesta) {
            // jQuery ya parseó el JSON automáticamente
            let template_bar = `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;
            
            // SE HACE VISIBLE LA BARRA DE ESTADO
            $('#product-result').removeClass('d-none').addClass('d-block');
            $('#container').html(template_bar);
            
            // SE LIMPIAN LOS CAMPOS Y SE VUELVE A MODO AGREGAR
            limpiarFormulario();
            $('.btn-primary').text('Agregar Producto');
            edit = false;
            
            // SE LISTAN TODOS LOS PRODUCTOS
            listarProductos();
        },
        error: function(xhr, status, error) {
            console.error('Error al modificar producto:', error);
            console.log('Respuesta del servidor:', xhr.responseText);
        }
    });
}

// ELIMINAR PRODUCTO
function eliminarProducto(id) {
    $.ajax({
        url: './backend/product',
        type: 'DELETE',
        contentType: 'application/x-www-form-urlencoded',
        data: { id: id },
        success: function(respuesta) {
            // jQuery ya parseó el JSON automáticamente
            let template_bar = `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;
            
            // SE HACE VISIBLE LA BARRA DE ESTADO
            $('#product-result').removeClass('d-none').addClass('d-block');
            $('#container').html(template_bar);
            
            // SE LISTAN TODOS LOS PRODUCTOS
            listarProductos();
        },
        error: function(xhr, status, error) {
            console.error('Error al eliminar producto:', error);
            console.log('Respuesta del servidor:', xhr.responseText);
        }
    });
}

// LIMPIAR FORMULARIO
function limpiarFormulario() {
    $('#productId').val('');
    $('#name').val('');
    $('#precio').val('');
    $('#cantidad').val('');
    $('#modelo').val('');
    $('#marca').val('');
    $('#detalles').val('');
    $('#imagen').val('');
    
    // Limpiar mensajes de validación
    $('small').text('').removeClass('text-success text-danger text-warning');
}