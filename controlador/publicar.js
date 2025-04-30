$(document).ready(function(){
    $("form").on("submit", function(event){
        event.preventDefault();

        const archivo=$("#pdf")[0].files[0];

        //validamos que solo sea un solo archivo formato PDF
        if(archivo.type!=="application/pdf"){
            alert("el archivo debe ser un PDF. "+archivo.type);
            return;
        }
        if (archivo.length > 1) {
            alert("Solo puedes subir un archivo a la vez.");
            // limpiar input
            input.value = ''; 
        
            return;
        }
        const formData=new FormData(this);

        $.ajax({
            url:"../controlador/publicarController.php",
            type:"POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){
                alert(response);
                $("#formPublicar")[0].reset();
                //hay que añadir una función para crear avisos
            },
            error: function(){
                alert("error al subir el archivo");
            }
        })

    })
})