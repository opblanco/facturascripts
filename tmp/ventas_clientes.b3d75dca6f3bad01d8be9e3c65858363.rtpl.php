<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>


<script type="text/javascript">
   function show_nuevo_cliente()
   {
      $("#modal_nuevo_cliente").modal('show');
      document.f_nuevo_cliente.nombre.focus();
   }
   function show_grupos()
   {
      $('#tab_clientes a[href="#grupos"]').tab('show');
   }
   $(document).ready(function() {
      document.f_custom_search.query.focus();
      
      <?php if( $fsc->clientes_grupo!==FALSE ){ ?>

      $('#tab_clientes a[href="#clientes_grupo"]').tab('show');
      <?php } ?>

      
      if(window.location.hash.substring(1) == 'nuevo')
      {
         show_nuevo_cliente();
      }
      else if(window.location.hash.substring(1) == 'grupos')
      {
         show_grupos();
      }
      
      $("#b_nuevo_cliente").click(function(event) {
         event.preventDefault();
         show_nuevo_cliente();
      });
   });
</script>

<div class="container-fluid" style="margin-top: 10px;">
   <div class="row">
      <div class="col-md-2">
         <div class="btn-group hidden-xs">
            <a class="btn btn-sm btn-default" href="<?php echo $fsc->url();?>" title="Recargar la página">
               <span class="glyphicon glyphicon-refresh"></span>
            </a>
            <?php if( $fsc->page->is_default() ){ ?>

            <a class="btn btn-sm btn-default active" href="<?php echo $fsc->url();?>&amp;default_page=FALSE" title="desmarcar como página de inicio">
               <span class="glyphicon glyphicon-home"></span>
            </a>
            <?php }else{ ?>

            <a class="btn btn-sm btn-default" href="<?php echo $fsc->url();?>&amp;default_page=TRUE" title="marcar como página de inicio">
               <span class="glyphicon glyphicon-home"></span>
            </a>
            <?php } ?>

         </div>
         
         <a href="#" id="b_nuevo_cliente" class="btn btn-sm btn-success">
            <span class="glyphicon glyphicon-plus"></span> &nbsp; Nuevo...
         </a>
      </div>
      <div class="col-md-8 text-center">
         <h2 style="margin-top: 0px;">
            <?php if( $fsc->query=='' ){ ?>Clientes<?php }else{ ?>Resultados de la búsqueda "<?php echo $fsc->query;?>":<?php } ?>

         </h2>
      </div>
      <div class="col-md-2">
         <form name="f_custom_search" action="<?php echo $fsc->url();?>" method="post" class="form">
            <div class="input-group">
               <input class="form-control" type="text" name="query" value="<?php echo $fsc->query;?>" autocomplete="off" placeholder="Buscar">
               <span class="input-group-btn">
                  <button class="btn btn-primary" type="submit">
                     <span class="glyphicon glyphicon-search"></span>
                  </button>
               </span>
            </div>
         </form>
      </div>
   </div>
</div>

<div id="tab_clientes" role="tabpanel">
   <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Todos</a></li>
      <li role="presentation"><a href="#grupos" aria-controls="grupos" role="tab" data-toggle="tab">Grupos</a></li>
      <?php if( $fsc->clientes_grupo!==FALSE ){ ?>

      <li role="presentation">
         <a href="#clientes_grupo" aria-controls="clientes_grupo" role="tab" data-toggle="tab">
            <span class="glyphicon glyphicon-eye-open"></span> &nbsp; <?php echo $fsc->nombre_grupo($_GET['grupo']);?>

         </a>
      </li>
      <?php } ?>

   </ul>
   <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="home">
         <div class="table-responsive">
            <table class="table table-hover">
               <thead>
                  <tr>
                     <th class="text-left">Código + Nombre</th>
                     <th class="text-left"><?php  echo FS_CIFNIF;?></th>
                     <th class="text-left">Observaciones</th>
                     <th class="text-right">Grupo</th>
                  </tr>
               </thead>
               <?php $loop_var1=$fsc->resultados; $counter1=-1; if($loop_var1) foreach( $loop_var1 as $key1 => $value1 ){ $counter1++; ?>

               <tr class="clickableRow" href="<?php echo $value1->url();?>">
                  <td><a href="<?php echo $value1->url();?>"><?php echo $value1->codcliente;?></a> <?php echo $value1->nombre;?></td>
                  <td><?php echo $value1->cifnif;?></td>
                  <td><?php echo $value1->observaciones_resume();?></td>
                  <td class="text-right"><?php echo $fsc->nombre_grupo($value1->codgrupo);?></td>
               </tr>
               <?php }else{ ?>

               <tr class="bg-warning">
                  <td colspan="4">Ningún cliente encontrado. Pulse el botón <b>Nuevo</b> para crear uno.</td>
               </tr>
               <?php } ?>

            </table>
         </div>
         
         <ul class="pager" id="ul_paginador">
            <?php if( $fsc->anterior_url()!='' ){ ?>

            <li class="previous">
               <a href="<?php echo $fsc->anterior_url();?>">
                  <span class="glyphicon glyphicon-chevron-left"></span> &nbsp; Anteriores
               </a>
            </li>
            <?php } ?>

            
            <?php if( $fsc->siguiente_url()!='' ){ ?>

            <li class="next">
               <a href="<?php echo $fsc->siguiente_url();?>">
                  Siguientes &nbsp; <span class="glyphicon glyphicon-chevron-right"></span>
               </a>
            </li>
            <?php } ?>

         </ul>
      </div>
      <div role="tabpanel" class="tab-pane" id="grupos">
         <table class="table table-hover">
            <thead>
               <tr>
                  <th width="70"></th>
                  <th class="text-left">Código</th>
                  <th class="text-left">Nombre</th>
                  <th class="text-left">Tarifa</th>
                  <th class="text-right" width="120">Acción</th>
               </tr>
            </thead>
            <?php $loop_var1=$fsc->grupos; $counter1=-1; if($loop_var1) foreach( $loop_var1 as $key1 => $value1 ){ $counter1++; ?>

            <form action="<?php echo $fsc->url();?>#grupos" method="post" class="form">
               <tr>
                  <td>
                     <a href="<?php echo $fsc->url();?>&grupo=<?php echo $value1->codgrupo;?>" class="btn btn-sm btn-default" title="ver los clientes de este grupo">
                        <span class="glyphicon glyphicon-eye-open"></span>
                     </a>
                  </td>
                  <td>
                     <input class="form-control" type="text" name="codgrupo" value="<?php echo $value1->codgrupo;?>" readonly="true"/>
                  </td>
                  <td>
                     <input class="form-control" type="text" name="nombre" value="<?php echo $value1->nombre;?>" maxlength="50" autocomplete="off"/>
                  </td>
                  <td>
                     <select name="codtarifa" class="form-control">
                        <option value="---">Ninguna</option>
                        <option value="---">---</option>
                        <?php $loop_var2=$fsc->tarifa->all(); $counter2=-1; if($loop_var2) foreach( $loop_var2 as $key2 => $value2 ){ $counter2++; ?>

                           <?php if( $value1->codtarifa==$value2->codtarifa ){ ?>

                           <option value="<?php echo $value2->codtarifa;?>" selected="selected"><?php echo $value2->nombre;?></option>
                           <?php }else{ ?>

                           <option value="<?php echo $value2->codtarifa;?>"><?php echo $value2->nombre;?></option>
                           <?php } ?>

                        <?php } ?>

                     </select>
                  </td>
                  <td class="text-right">
                     <div class="btn-group">
                        <a class="btn btn-sm btn-danger" title="Eliminar" href="<?php echo $fsc->url();?>&delete_grupo=<?php echo $value1->codgrupo;?>#grupos">
                           <span class="glyphicon glyphicon-trash"></span>
                        </a>
                        <button class="btn btn-sm btn-primary" type="submit" title="Guardar" onclick="this.disabled=true;this.form.submit();">
                           <span class="glyphicon glyphicon-floppy-disk"></span>
                        </button>
                     </div>
                  </td>
               </tr>
            </form>
            <?php } ?>

            <form name="f_new_grupo" action="<?php echo $fsc->url();?>#grupos" method="post" class="form">
               <tr class="bg-info">
                  <td></td>
                  <td>
                     <input class="form-control" type="text" name="codgrupo" value="<?php echo $fsc->grupo->get_new_codigo();?>" maxlength="6" autocomplete="off"/>
                  </td>
                  <td>
                     <input class="form-control" type="text" name="nombre" maxlength="50" placeholder="Nuevo grupo" autocomplete="off"/>
                  </td>
                  <td>
                     <select name="codtarifa" class="form-control">
                        <option value="---">Ninguna</option>
                        <option value="---">---</option>
                        <?php $loop_var1=$fsc->tarifa->all(); $counter1=-1; if($loop_var1) foreach( $loop_var1 as $key1 => $value1 ){ $counter1++; ?>

                        <option value="<?php echo $value1->codtarifa;?>"><?php echo $value1->nombre;?></option>
                        <?php } ?>

                     </select>
                  </td>
                  <td class="text-right">
                     <button class="btn btn-sm btn-primary" type="submit" onclick="this.disabled=true;this.form.submit();" title="Guardar">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                     </button>
                  </td>
               </tr>
            </form>
         </table>
      </div>
      <?php if( $fsc->clientes_grupo!==FALSE ){ ?>

      <div role="tabpanel" class="tab-pane" id="clientes_grupo">
         <div class="table-responsive">
            <table class="table table-hover">
               <thead>
                  <tr>
                     <th class="text-left">Código + Nombre</th>
                     <th class="text-left"><?php  echo FS_CIFNIF;?></th>
                     <th class="text-left">Observaciones</th>
                  </tr>
               </thead>
               <?php $loop_var1=$fsc->clientes_grupo; $counter1=-1; if($loop_var1) foreach( $loop_var1 as $key1 => $value1 ){ $counter1++; ?>

               <tr class="clickableRow" href="<?php echo $value1->url();?>">
                  <td><a href="<?php echo $value1->url();?>"><?php echo $value1->codcliente;?></a> <?php echo $value1->nombre;?></td>
                  <td><?php echo $value1->cifnif;?></td>
                  <td><?php echo $value1->observaciones_resume();?></td>
               </tr>
               <?php }else{ ?>

               <tr class="bg-warning">
                  <td colspan="3">Ningún cliente encontrado.</td>
               </tr>
               <?php } ?>

            </table>
         </div>
      </div>
      <?php } ?>

   </div>
</div>

<form class="form-horizontal" role="form" name="f_nuevo_cliente" action="<?php echo $fsc->url();?>" method="post">
   <div class="modal" id="modal_nuevo_cliente">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
               <h4 class="modal-title">Nuevo cliente</h4>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label for="codserie" class="col-lg-2 col-md-2 col-sm-2 control-label"><a href="<?php echo $fsc->serie->url();?>">Serie</a></label>
                  <div class="col-lg-10 col-md-10 col-sm-10">
                     <select class="form-control" name="codserie">
                     <?php $loop_var1=$fsc->serie->all(); $counter1=-1; if($loop_var1) foreach( $loop_var1 as $key1 => $value1 ){ $counter1++; ?>

                        <option value="<?php echo $value1->codserie;?>"<?php if( $value1->is_default() ){ ?> selected="selected"<?php } ?>><?php echo $value1->descripcion;?></option>
                     <?php } ?>

                     </select>
                  </div>
               </div>
               <div class="form-group">
                  <label for="nombre" class="col-lg-2 col-md-2 col-sm-2 control-label">Nombre</label>
                  <div class="col-lg-10 col-md-10 col-sm-10">
                     <input class="form-control" type="text" name="nombre" autocomplete="off"/>
                  </div>
               </div>
               <div class="form-group">
                  <label for="cifnif" class="col-lg-2 col-md-2 col-sm-2 control-label"><?php  echo FS_CIFNIF;?></label>
                  <div class="col-lg-10 col-md-10 col-sm-10">
                     <input class="form-control" type="text" name="cifnif" autocomplete="off"/>
                  </div>
               </div>
               <div class="form-group">
                  <label for="pais" class="col-lg-2 col-md-2 col-sm-2 control-label"><a href="<?php echo $fsc->pais->url();?>">País</a></label>
                  <div class="col-lg-10 col-md-10 col-sm-10">
                     <select class="form-control" name="pais">
                     <?php $loop_var1=$fsc->pais->all(); $counter1=-1; if($loop_var1) foreach( $loop_var1 as $key1 => $value1 ){ $counter1++; ?>

                        <option value="<?php echo $value1->codpais;?>"<?php if( $value1->is_default() ){ ?> selected="selected"<?php } ?>><?php echo $value1->nombre;?></option>
                     <?php } ?>

                     </select>
                  </div>
               </div>
               <div class="form-group">
                  <label for="provincia" class="col-lg-2 col-md-2 col-sm-2 control-label text-capitalize"><?php  echo FS_PROVINCIA;?></label>
                  <div class="col-lg-10 col-md-10 col-sm-10">
                     <input class="form-control" type="text" name="provincia" autocomplete="off" value="<?php echo $fsc->empresa->provincia;?>"/>
                  </div>
               </div>
               <div class="form-group">
                  <label for="ciudad" class="col-lg-2 col-md-2 col-sm-2 control-label">Ciudad</label>
                  <div class="col-lg-10 col-md-10 col-sm-10">
                     <input class="form-control" type="text" name="ciudad" autocomplete="off" value="<?php echo $fsc->empresa->ciudad;?>"/>
                  </div>
               </div>
               <div class="form-group">
                  <label for="codpostal" class="col-lg-2 col-md-2 col-sm-2 control-label">Código Postal</label>
                  <div class="col-lg-10 col-md-10 col-sm-10">
                     <input class="form-control" type="text" name="codpostal" autocomplete="off" value="<?php echo $fsc->empresa->codpostal;?>"/>
                  </div>
               </div>
               <div class="form-group">
                  <label for="direccion" class="col-lg-2 col-md-2 col-sm-2 control-label">Dirección</label>
                  <div class="col-lg-10 col-md-10 col-sm-10">
                     <input class="form-control" type="text" name="direccion" value="C/ " autocomplete="off"/>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button class="btn btn-sm btn-primary" type="submit" onclick="this.disabled=true;this.form.submit();">
                  <span class="glyphicon glyphicon-floppy-disk"></span> &nbsp; Guardar
               </button>
            </div>
         </div>
      </div>
   </div>
</form>

<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>