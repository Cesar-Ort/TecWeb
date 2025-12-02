<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" >
    <title>Registro al Concurso</title>
    <style type="text/css">
      body { font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; max-width: 900px; margin: 24px auto; padding: 0 12px; }
        ul { list-style-type: none; padding-left: 0;}
        legend {font-weight: bold; }
        fieldset { margin-top: 16px; padding: 15px; }
        li { margin: 10px 0; }
        label { display: inline-block; width: 160px; }
        .actions { margin-top: 12px; }
    </style>
  </head>
<body>
  <h1>Agregación de producto</h1>

  
  <form id="formularioProducto" action="http://localhost/tecweb/practicas/p08/set_producto_v2.php" method="post">

    <fieldset>
      <legend>Formulario para Tintas</legend>
      <ul>
        <li>
          <label for="nombre">Nombre:</label>
          <input type="text" name="nombre" id="nombre"  placeholder="Nombre del producto">
        </li>
        <li>
          <label for="marca">Marca:</label>
          <select name="marca" id="marca" >
              <option value="">-- SELECCIONA UNO --</option>
              <option value="brother">Brother</option>
              <option value="hp">HP</option>
              <option value="epson">Epson</option>
              <option value="canon">Canon</option>
              <option value="generico">Generico</option>
          </select>
        </li>
        <li>
          <label for="modelo">Modelo:</label>
          <input type="text" name="modelo" id="modelo"  placeholder="Modelo de equipo">
        </li>
        <li>
          <label for="precio">Precio:</label>
          <input type="number" name="precio" id="precio"   min="100" max="1000000" placeholder="Precio al público">
        </li>
        <li>
          <label for="cantidad">Unidades:</label>
          <input type="number" name="cantidad" id="cantidad"  max="100000" placeholder="Piezas disponibles">
        </li>
        <li>
          <label for="detalles">Detalles:</label>
          <input type="text" name="detalles" id="detalles" maxlength="250" placeholder="Descripción del producto ">
        </li>
        <li>
          <label for="imagen">Imagen (URL):</label>
          <textarea name="imagen" id="imagen" rows="3" cols="60" maxlength="500" placeholder="URL de la imagen (opcional)"></textarea>
        </li>
      </ul>
    </fieldset>

    <p class="actions">
      <input type="submit" value="Enviar formulario">
      <input type="reset" value="Restablecer">
    </p>
  </form>
  <script>
    document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("formularioProducto");

    form.addEventListener("submit", function (event) {
        
        // Obtener valores
        const nombre = document.getElementById("nombre").value.trim();
        const marca = document.getElementById("marca").value;
        const modelo = document.getElementById("modelo").value.trim();
        const precioRaw = document.getElementById("precio").value;
        const precio = precioRaw === "" ? NaN : parseFloat(precioRaw);
        const detalles = document.getElementById("detalles").value.trim();
        const unidadesRaw = document.getElementById("cantidad").value;
        const unidades = unidadesRaw === "" ? NaN : parseInt(unidadesRaw, 10);
        const imagen = document.getElementById("imagen").value.trim();

        let errores = "";

        // Validación del nombre: menos de 100 caracteres
        if (nombre === "" || nombre.length > 100) {
            errores += "- ERROR 00 \n El nombre es obligatorio y debe tener máximo 100 caracteres.\n";
        }

        // Validación de la marca: debe elegirse (select)
        if (marca === "" ) {
            errores += "- ERROR 01 \n Debes seleccionar una marca.\n";
        }

        // Validación del modelo: que sea alfanumérico y menos de 25 caracteres
        const regexModelo = /^[A-Za-z0-9\s\-]+$/;
        if (modelo === "" || modelo.length > 25 || !regexModelo.test(modelo)) {
            errores += "- ERROR 03 \n El modelo es obligatorio, máximo 25 caracteres y solo caracteres alfanuméricos, espacios o guiones.\n";
        }

        // Validación del precio: debe ser mayor a 99.99
        if (isNaN(precio) || precio <= 99.99) {
            errores += "- ERROR 04 \n El precio debe ser un número mayor a 99.99.\n";
        }

        // Validación de los detalles: es opcional, pero si se usa que sea menor a 250 caracteres
        if (detalles.length > 250) {
            errores += "- ERR0R 05 \n Los detalles deben tener máximo 250 caracteres.\n";
        }

        // Validación de las unidades: tiene que ser mayor a 0
        if (isNaN(unidades) || unidades <= 0) {
            errores += "- ERROR 06 \n Las unidades deben ser un número entero mayor o igual a 0.\n";
        }

        // Validación de la imagen: si está vacío, se asigna ruta por defecto (no impide envío)
        if (imagen === "") {
            // No sobrescribimos si el servidor espera no enviar imagen; ajusta si tu backend espera otro comportamiento.
            document.getElementById("imagen").value = "src/imagen.png";
        }

        // Si hay errores → cancelar envío
        if (errores !== "") {
            alert("Corrige los siguientes errores:\n\n" + errores);
            event.preventDefault();
            return false;
        }

        
    });
});

  </script>
</body>
</html>
