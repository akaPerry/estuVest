$(document).ready(function () {
    const loaderHTML = `
        <div id="loader-overlay" style="
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(255,255,255,0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        ">
            <div class="spinner" style="
                border: 6px solid #f3f3f3;
                border-top: 6px solid #3498db;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                animation: spin 1s linear infinite;
            "></div>
        </div>
        <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        </style>
    `;

    $("#enviar").on("click", function (e) {
        e.preventDefault();

        const $form = $(this).closest("form");
        const formData = new FormData($form[0]);

        // Mostrar loader desde el inicio
        if (!$("#loader-overlay").length) $("body").append(loaderHTML);

        // Paso 1: Enviar el código 2FA al correo
        $.ajax({
            url: "../controlador/enviar2fa.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                $("#loader-overlay").remove();

                if ($.trim(res) !== "ok") {
                    Swal.fire("Error", "No se pudo enviar el código de verificación.", "error");
                    return;
                }
                mostrarPopupCodigo($form); // Paso 2
            },
            error: function () {
                $("#loader-overlay").remove();
                Swal.fire("Error", "No se pudo enviar el código. Intenta de nuevo.", "error");
            }
        });
    });

    function mostrarPopupCodigo($form) {
        Swal.fire({
            title: "Verificación en dos pasos",
            input: "text",
            inputLabel: "Introduce el código de 6 dígitos enviado a tu correo",
            inputPlaceholder: "######",
            inputAttributes: {
                maxlength: 6,
                pattern: "[0-9]{6}",
                autocapitalize: "off",
                autocorrect: "off"
            },
            showCancelButton: true,
            confirmButtonText: "Verificar",
            inputValidator: (value) => {
                if (!/^\d{6}$/.test(value)) {
                    return "El código debe tener exactamente 6 dígitos.";
                }
            }
        }).then((result) => {
            if (!result.value) return;

            if (!$("#loader-overlay").length) $("body").append(loaderHTML);

            // Paso 3: Verificar código
            $.ajax({
                url: "../controlador/verificar2fa.php",
                type: "POST",
                data: { codigo: result.value },
                success: function (validacion) {
                    if ($.trim(validacion) === "ok") {
                        // Paso 4: Enviar login manualmente a logUsuController.php
                        const datosLogin = {
                            nick: $form.find("input[name='nick']").val(),
                            contrasenia: $form.find("input[name='contrasenia']").val()
                        };

                        $.ajax({
                            url: "../controlador/logUsuController.php",
                            type: "POST",
                            data: datosLogin,
                            success: function (respuesta) {
                                $("#loader-overlay").remove();
                                console.log(respuesta);
                                console.log('toy aqui');
                                if (respuesta.startsWith("redirect:")) {
                                    const url = respuesta.replace("redirect:", "").trim();
                                    window.location.href = url;
                                } else if (respuesta.startsWith("error:")) {
                                    const mensaje = respuesta.replace("error:", "").trim();
                                    Swal.fire("Error en login", mensaje, "error");
                                    mostrarPopupCodigo($form);
                                } else {
                                    Swal.fire("Error inesperado", "Respuesta no reconocida del servidor.", "error");
                                    mostrarPopupCodigo($form);
                                }
                            },
                            error: function () {
                                $("#loader-overlay").remove();
                                Swal.fire("Error", "Hubo un problema al iniciar sesión.", "error");
                                mostrarPopupCodigo($form);
                            }
                        });

                    } else {
                        $("#loader-overlay").remove();
                        Swal.fire("Código incorrecto", "El código ingresado no es válido o ha expirado.", "error");
                        mostrarPopupCodigo($form);
                    }
                },
                error: function () {
                    $("#loader-overlay").remove();
                    Swal.fire("Error", "Error al verificar el código.", "error");
                    mostrarPopupCodigo($form);
                }
            });
        });
    }
})