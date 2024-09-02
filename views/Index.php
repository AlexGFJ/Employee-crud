<?php
// @codingStandardsIgnoreStart
// -*- php -*-
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <script src="./assets/js/jquery-3.6.0.min.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <script src="./assets/PDF/pdfmake.min.js"></script>
    <script src="./assets/PDF/vfs_fonts.js"></script>
        
</head>
<body>
<div class="container">
    <h2 class="mt-5">CRUD de Empleados</h2>

    <!-- Botón para abrir el modal de agregar empleado -->
    <button id="addUserBtn" class="btn btn-primary mb-3">Agregar Empleado</button>
    <!-- Botón para generar PDF -->
    <button id="generatePDFBtn" class="btn btn-secondary mb-3">Generar PDF</button>


    <!-- Tabla para mostrar los empleados -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Empleado</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Empresa</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="userTable">
            <!-- Los datos de los empleados se insertarán aquí dinámicamente -->
        </tbody>
    </table>
</div>

<!-- Modal para Agregar y Editar empleado -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Agregar empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario dentro del modal -->
                <form id="userForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="adress" class="form-label">Dirección</label>
                        <input type="adress" class="form-control" id="adress" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefono</label>
                        <input type="phone" class="form-control" id="phone"  maxlength="10" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="company" class="form-label">Empresa</label>
                        <select class="form-select" id="company" required>
                            <!-- Opciones de empresas se llenarán aquí -->
                        </select>
                    </div>
                    <input type="hidden" id="userId"> <!-- Campo oculto para el ID del empleado -->
                    <button type="submit" class="btn btn-primary" id="submitBtn">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('generatePDFBtn').addEventListener('click', function() {
            // Obtener la tabla y sus datos
            const table = document.querySelector('.table');
            const headers = [];
            const data = [];
            
            // Obtener encabezados y eliminar el último encabezado
            table.querySelectorAll('thead th').forEach((th, index, ths) => {
                if (index < ths.length - 1) {
                    headers.push(th.innerText);
                }
            });
            
            // Obtener filas y eliminar la última columna de cada fila
            table.querySelectorAll('tbody tr').forEach(tr => {
                const row = [];
                tr.querySelectorAll('td').forEach((td, index, tds) => {
                    if (index < tds.length - 1) {
                        row.push(td.innerText);
                    }
                });
                data.push(row);
            });
            
            // Preparar el contenido del PDF
            const docDefinition = {
                pageSize: 'A4',
                pageMargins: [40, 60, 40, 60],
                content: [
                    {
                        table: {
                            headerRows: 1,
                            widths: [20, 50, 100, 50, 100, 100], // Ajusta el ancho de las columnas restantes
                            body: [
                                headers,
                                ...data
                            ]
                        },
                        layout: 'lightHorizontalLines' // Aplica un diseño de líneas horizontales ligeras
                    }
                ],
                defaultStyle: {
                    fontSize: 10 // Tamaño de fuente más pequeño
                }
            };
            
            // Generar el PDF
            pdfMake.createPdf(docDefinition).download('tabla.pdf');
        });
    });
    </script>
    
    
<script>
    
    $(document).ready(function() {
    // Función para obtener todos los empleados y actualizar la tabla
    function fetchUsers() {
        $.ajax({
            url: "./controllers/UserController.php?action=readAll",
            type: "GET",
            success: function(data) {
                var users = JSON.parse(data); // Convertir la respuesta JSON en un objeto
                var html = '';
                $.each(users, function(key, user) {
                    html += '<tr>';
                    html += '<td>' + user.Id_empleado + '</td>'; // Mostrar el ID del empleado
                    html += '<td>' + user.Nombre + '</td>'; // Mostrar el nombre del empleado
                    html += '<td>' + user.Direccion + '</td>'; // Mostrar la dirección del empleado
                    html += '<td>' + user.Telefono + '</td>'; // Mostrar el teléfono del empleado
                    html += '<td>' + user.email + '</td>'; // Mostrar el email del empleado
                    html += '<td>' + user.empresa + '</td>'; // Mostrar la empresa del empleado
                    html += '<td><button class="btn btn-warning editUser" data-id="' + user.Id_empleado + '" data-name="' + user.Nombre + '" data-adress="' + user.Direccion + '" data-phone="' + user.Telefono +'" data-email="' + user.email + '" data-company="' + user.Id_empresa + '">Editar</button> <button class="btn btn-danger deleteUser" data-id="' + user.Id_empleado + '">Eliminar</button></td>';
                    html += '</tr>';
                });
                $('#userTable').html(html); // Actualizar la tabla con los datos de los empleados
            }
        });
    }

    function fetchCompanies() {
        return $.ajax({
            url: "./controllers/UserController.php?action=getCompanies",
            type: "GET",
            success: function(data) {
                var companies = JSON.parse(data); // Convertir la respuesta JSON en un objeto
                var options = '<option value="">Selecciona una empresa</option>';
                $.each(companies, function(key, company) {
                    options += '<option value="' + company.Id_empresa + '">' + company.Nombre + '</option>';
                });
                $('#company').html(options); // Llenar el select con las opciones de empresas
            }
        });
    }

    // Mostrar el modal para agregar un nuevo empleado
    $('#addUserBtn').click(function() {
        $('#userModalLabel').text('Agregar Empleado'); // Cambiar el título del modal
        $('#userForm')[0].reset(); // Resetear el formulario
        $('#userId').val(''); // Limpiar el campo oculto del ID
        $('#submitBtn').text('Guardar'); // Cambiar el texto del botón
        fetchCompanies(); // Cargar las empresas
        $('#userModal').modal('show'); // Mostrar el modal
    });

    // Manejar el envío del formulario (agregar/editar empleado)
    $('#userForm').submit(function(event) {
        event.preventDefault(); // Prevenir el comportamiento predeterminado del formulario
        var id = $('#userId').val(); // Obtener el ID del empleado (si existe)
        var name = $('#name').val(); // Obtener el nombre del empleado
        var adress = $('#adress').val(); // Obtener la dirección del empleado
        var phone = $('#phone').val(); // Obtener el teléfono del empleado
        var email = $('#email').val(); // Obtener el email del empleado
        var company = $('#company').val(); // Obtener la empresa seleccionada
        var action = id ? 'update' : 'create'; // Determinar si es una acción de actualización o creación

        $.ajax({
            url: "./controllers/UserController.php?action=" + action,
            type: "POST",
            data: { id: id, name: name, adress: adress, phone: phone, email: email, company: company }, // Enviar los datos al servidor
            success: function(data) {
                fetchUsers(); // Actualizar la tabla con los nuevos datos
                $('#userModal').modal('hide'); // Ocultar el modal
                Swal.fire('Éxito', 'El Empleado ha sido guardado.', 'success'); // Mostrar mensaje de éxito
            }
        });
    });

    // Mostrar el modal para editar un empleado
    $(document).on('click', '.editUser', function() {
        var id = $(this).data('id'); // Obtener el ID del empleado desde el botón
        var name = $(this).data('name'); // Obtener el nombre del empleado desde el botón
        var adress = $(this).data('adress'); // Obtener la dirección del empleado desde el botón
        var phone = $(this).data('phone'); // Obtener el teléfono del empleado desde el botón
        var email = $(this).data('email'); // Obtener el email del empleado desde el botón
        var company = $(this).data('company'); // Obtener el ID de la empresa del empleado desde el botón

        $('#userModalLabel').text('Editar Empleado'); // Cambiar el título del modal
        $('#name').val(name); // Rellenar el campo de nombre
        $('#adress').val(adress); // Rellenar el campo de dirección
        $('#phone').val(phone); // Rellenar el campo de teléfono
        $('#email').val(email); // Rellenar el campo de email
        $('#userId').val(id); // Rellenar el campo oculto del ID
        $('#submitBtn').text('Actualizar'); // Cambiar el texto del botón

        // Cargar las empresas y seleccionar la correcta
        fetchCompanies().done(function() {
            $('#company').val(company); // Seleccionar la opción correcta en el select
        });

        $('#userModal').modal('show'); // Mostrar el modal
    });

    // Confirmar y eliminar un empleado
    $(document).on('click', '.deleteUser', function() {
        var id = $(this).data('id'); // Obtener el ID del empleado desde el botón
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "./controllers/UserController.php?action=delete",
                    type: "POST",
                    data: { id: id }, // Enviar el ID del empleado al servidor
                    success: function(data) {
                        fetchUsers(); // Actualizar la tabla con los datos restantes
                        Swal.fire('Eliminado', 'El empleado ha sido eliminado.', 'success'); // Mostrar mensaje de éxito
                    }
                });
            }
        });
    });

    // Cargar los empleados al iniciar la página
    fetchUsers();
});
</script>
