<!DOCTYPE HTML>

<html lang="es">
    <head>
        <meta charset="utf-8"/>
        <title>CRUD PRODUCTO</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>
        <script src="https://malsup.github.io/jquery.form.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="assets/js/utility.js"></script>


        <style>
            input{
                margin-top:5px;
                margin-bottom:5px;
            }
            .right{
                float:right;
            }

            .caja1{
                display: flex;
                flex-flow: column wrap;
                justify-content: center;
                align-items: center;
            }
            .caja2{
                width: 100%;
                height: 00%;
                overflow: hidden;
            }

            .caja2 img{
                width: 85%;
                height: 85%;
            }
            @supports(object-fit: cover){
                .caja2 img{
                    height: 85%;
                    object-fit: cover;
                    object-position: center center;
                }
            }

        </style>

        <script type="text/javascript">
            $(function(){
                $('.toUpper').keyup(function () {
                    $(this).val($(this).val().toUpperCase());
                });

                $('.impuesto').mask('000.00', { reverse: true });
                $('.precio').mask('000,000,000,000,000.00', { reverse: true });



                $('#btnNuevo').on('click',function(){

                    $('#operacion').val('new');

                    $("#modal-editar").modal('show');

                    $('#referencia').val('');
                    $('#nombre').val('');
                    $('#observacion').val('');
                    $('#precio').val(0.00);
                    $('#impuesto').val(0.00);
                    $('#cantidad').val(0);
                    $('#imagen').val('NA');

                    $('#imagePreview').empty();

                    document.getElementById('referencia').readOnly = false;

                });

                $('#formProducto').ajaxForm({
                    beforeSubmit:function(formData, jqForm, options){
                        return $('#formProducto').valid();
                    },
                    success:function(responseText, statusText, xhr, form){
                        var json = $.parseJSON(responseText);

                        Swal.fire(({
                            title: 'Oops...',
                            icon: 'warning',
                            text: json.msg
                        }));

                        if(json.error === '0' ){

                            $("#modal-editar").modal('hide');
                            javascript:location.reload(true);
                        }


                        return false;
                    }
                });
            });

            function buscar(ref)
            {
                    $('#operacion').val('update');

                    $.post('<?php echo $helper->url("Producto", "buscar") ?>',  {'referencia': ref }, function(ans)
                    {

                        $('#referencia').val( ans.info.referencia);
                        $('#nombre').val(ans.info.nombre);
                        $('#observacion').val(ans.info.observacion);
                        $('#precio').val(ans.info.precio);
                        $('#impuesto').val(ans.info.impuesto);
                        $('#cantidad').val(ans.info.cantidad);
                        $('#imagen').val(ans.info.imagen);

                        $('#estado').val(ans.info.estado);

                        $('#imagePreview').empty();

                        document.getElementById('referencia').readOnly = true;

                        document.getElementById('imagePreview').innerHTML = '<img src="assets/productos/' + ans.info.imagen + '"/>';

                        $("#modal-editar").modal('show');

                    },'json');


            }

            function fileValidation(){
                var fileInput = document.getElementById('userfile');
                var filePath = fileInput.value;

                //EXTENSIONES VALIDAS
                var allowedExtensions = /(.jpg)$/i;

                //OBTENEMOS EL TAMAÑO DEL ARCHIVO SELECCIONADO EN BYTE
                var fileSize = document.getElementById('userfile').files[0].size

                //TAMAÑO MAXIMO DEL ARCHIVO QUE SE PERMITE EN MEGAS
                var tamano   = parseFloat('0.1953125', 10);

                //CALCULAMOS EL TAMAÑO DEL ARCHIVO SELECCIONADO EN MEGAS
                var siezekiloByte = parseFloat(fileSize / 1048576.0, 10).toFixed(2);

                //VALIDAMOS QUE EL ARCHIVO NO SUPEREEL TAMAÑO PERMITIDO
                if(siezekiloByte > tamano)
                {
                    fileInput.value = '';

                    Swal.fire(({
                        title: 'Oops...',
                        icon: 'warning',
                        text: 'El tamaño máximo permitido es de 200KB'
                    }));


                    return false;
                }

                //VALIDAMOS EXTENSION ARCHIVO
                if(!allowedExtensions.exec(filePath)){
                    fileInput.value = '';

                    Swal.fire(({
                        title: 'Oops...',
                        icon: 'warning',
                        text: 'El archivo debe ser en formato JPG.'
                    }));

                    return false;
                }else{
                    //Image preview
                    if (fileInput.files && fileInput.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {

                            $('#imagePreview').empty();

                            document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'"/>';
                        };
                        reader.readAsDataURL(fileInput.files[0]);
                    }
                }

                return true;
            }

            function eliminarProducto(referencia){
                    Swal.fire({
                        title: '¿Desea Eliminar la Referencia: ' + referencia + '?',
                        html: '¡Puede cancelar la acción solicitada!<br>',
                        type: 'warning',
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Aceptar'
                    }).then(function(result){
                        if(result.value)
                        {
                            $.post('<?php echo $helper->url("Producto", "borrar") ?>',  {'refproducto': referencia }, function(ans)
                            {
                                Swal.fire(({
                                    title: ans.msg,
                                    icon: 'info',
                                    text: '.'
                                }));

                                //window.open('<?php echo $helper->url("Producto", "index") ?>',"_self");

                            },'json');



                        }
                    });
            }

        </script>

    </head>
    <body>
                <div class="col-lg-7">
                    <h3>Lista de Productos</h3>
                    <hr/>
                </div>
                    <section class="col-lg-10 lista" style="height:400px;overflow-y:scroll;">
                        <div class="row">
                            <div class="col-xs-12 tablausuario" >
                                <div class="box-body">
                                    <div class="tab-content table-responsive no-padding">
                                        <table class="table tablesecondary table-striped-secondary table-bordered-secondary table-hover" id="productos-datatable" width="90%">
                                            <thead>
                                            <tr>
                                                <th nowrap width=5%" colspan="2">
                                                    <button type="button"  class="btn btn-primary" id="btnNuevo" name="btnNuevo">Agregar</button>
                                                </th>
                                                <th nowrap width="10%">REFERENCIA</th>
                                                <th nowrap width="25%">NOMBRE</th>
                                                <th nowrap width="25%">OBSERVACION</th>
                                                <th nowrap width="10%">PRECIO</th>
                                                <th nowrap width="10%">IMPUESTO</th>
                                                <th nowrap width="5%">CANTIDAD</th>
                                                <th nowrap width="5%">ESTADO</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($productos as $prod)
                                                    {
                                                        echo '<tr>';
                                                        echo '<td>';
                                                            echo '<button type="button" id="btnEditar" name="btnEditar" class="btn btn-success" onclick="buscar(\''.$prod->referencia.'\');" >Editar</button>';
                                                        echo '</td>';
                                                        echo '<td>';
                                                        //echo '<a href="'.$helper->url("producto", "borrar").'&id='.$prod->referencia.'" class="btn btn-danger">Borrar</a>';
                                                        echo '<button type="button" onclick="eliminarProducto(\''.$prod->referencia.'\' );" class="btn btn-danger">Borrar</a>';

                                                        echo '</td>';
                                                        echo '<td>'.$prod->referencia.'</td>';
                                                        echo '<td>'.$prod->nombre.'</td>';
                                                        echo '<td>'.$prod->observacion.'</td>';
                                                        echo '<td>'.number_format($prod->precio, 2).'</td>';
                                                        echo '<td>'.number_format($prod->impuesto, 2).'</td>';
                                                        echo '<td>'.$prod->cantidad.'</td>';
                                                        echo '<td>'.$prod->estado.'</td>';
                                                        echo '</tr>';
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </section>

        <footer class="col-lg-12">
            <hr/>
            Prueba 2 - Alexander Gallardo Torres
        </footer>



    </body>
</html>

<!-- Modal -->
<div class="modal fade" id="modal-editar" role="dialog">
    <div class="modal-dialog " role="document">
        <form action="<?php echo $helper->url("producto", "editar"); ?>" method="post" id="formProducto" name="formProducto">
            <div class="modal-content">

                <div class="modal-header alert-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">PRODUCTO</h4>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="tab-content">

                                <div class="col-xs-4">
                                    <label>REFERENCIA</label>
                                    <input required type="text" class="form-control toUpper" id="referencia" name="referencia"  maxlength="15" onkeypress="return validaNumLetras(event);" />
                                    <input type="hidden"  id="operacion" name="operacion" />
                                    <input type="hidden"  id="imagen" name="imagen" />
                                </div>
                                <div class="col-xs-8">
                                    <label>NOMBRE PRODUCTO</label>
                                    <input required type="text" class="form-control toUpper" id="nombre" name="nombre"  maxlength="100" onkeypress="return validaLetrasOtro(event);" />
                                </div>
                                <div class="col-xs-12">
                                    <label>OBSERVACION</label>
                                    <input required type="text" class="form-control" id="observacion" name="observacion"  maxlength="150" onkeypress="return validaLetrasOtro(event);"/>
                                </div>
                                <div class="col-xs-4">
                                    <label>PRECIO</label>
                                    <input required type="text" class="form-control precio" id="precio" name="precio"  maxlength="20" />
                                </div>
                                <div class="col-xs-3">
                                    <label>IMPUESTO</label>
                                    <input required type="text" class="form-control impuesto" id="impuesto" name="impuesto"  maxlength="5" max="100" min="0" />
                                </div>
                                <div class="col-xs-2">
                                    <label>CANTIDAD</label>
                                    <input required type="text" class="form-control" id="cantidad" name="cantidad"  maxlength="4" min="0" max="9999" onkeypress="return validaNumericos(event);"/>
                                </div>
                                <div class="col-xs-3">
                                    <label>ESTADO</label>
                                    <select id="estado" name="estado" class="form-control">
                                        <option value="activo">Activo</option>
                                        <option value="inactivo">Inactivo</option>
                                    </select>
                                </div>

                                <div class="col-xs-12">
                                    <label>SELECCIONAR IMAGEN ( Solo formato jpg  )</label>
                                    <input required accept=".jpg" type="file" class="form-control" id='userfile' name="userfile" onchange="return fileValidation();"/>
                                </div>
                                <div class="col-xs-6">
                                    <div class="caja1">
                                        <div class="caja2" id="imagePreview">
                                            <!--img  src="#" style="width:120px;height:120px;border:#000 dotted"-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cerrar</button>
                </div>

            </div>
        </form>
    </div>
</div>