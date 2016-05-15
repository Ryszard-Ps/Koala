<?php
/**
* Mostrar detalles del xml
*
* @author Ricardo Pascual
* @author https://github.com/Ryszardp
*
**/
class MostrarArchivos{
    /**
    * @access private
    * @param  array
    * array de datos del archivo que devuelve la bd
    * A esta clase no puede ser accedida desde otra clase o desde otro lugar
    *
    **/
    private function crearDetalle($contexto){
        $ruta = 'archivos/' . $contexto['nombre_xml'] . ".xml";
        $sxe = simplexml_load_file($ruta);
        $ns = $sxe->getNamespaces(true);
        $sxe->registerXPathNamespace('c', $ns['cfdi']);
        $sxe->registerXPathNamespace('t', $ns['tfd']);
        $sxe->registerXPathNamespace('n', $ns['nomina']);

        foreach ($sxe->xpath('//c:Comprobante') as $cfdi) {
          $xml_comprobante_lugar_expedicion =$cfdi['LugarExpedicion'];
          $xml_comprobante_tipo_comprobante =$cfdi['tipoDeComprobante'];
          $xml_comprobante_sueldo =$cfdi['total'];
          $xml_comprobante_moneda =$cfdi['Moneda'];
          $xml_comprobante_mot_descuento =$cfdi['motivoDescuento'];
          $xml_comprobante_descuento =$cfdi['descuento'];
          $xml_comprobante_metodo_de_pago=$cfdi['metodoDePago'];
          $xml_comprobante_subtotal=$cfdi['subTotal'];
        }

        foreach ($sxe->xpath('//c:Emisor') as $cfdi) {
          $xml_emisor_nombre =$cfdi['nombre'];
          $xml_emisor_rfc =$cfdi['rfc'];
        }

        foreach ($sxe->xpath('//c:DomicilioFiscal') as $cfdi) {
          $xml_dom_fiscal_pais =$cfdi['pais'];
          $xml_dom_fiscal_cp =$cfdi['codigoPostal'];
          $xml_dom_fiscal_estado =$cfdi['estado'];
          $xml_dom_fiscal_municipio =$cfdi['municipio'];
          $xml_dom_fiscal_colonia =$cfdi['colonia'];
        }

        foreach ($sxe->xpath('//c:Receptor') as $cfdi) {
          $xml_receptor_nombre=$cfdi['nombre'];
          $xml_receptor_rfc=$cfdi['rfc'];
        }

        foreach ($sxe->xpath('//n:Nomina') as $cfdi) {
            $xml_nomina_periodicidad=$cfdi['PeriodicidadPago'];
            $xml_nomina_puesto=$cfdi['Puesto'];
            $xml_nomina_dpto=$cfdi['Departamento'];
            $xml_nomina_dias_pagados=$cfdi['NumDiasPagados'];
            $xml_nomina_fin_pago=$cfdi['FechaFinalPago'];
            $xml_nomina_inicio_pago=$cfdi['FechaInicialPago'];
            $xml_nomina_fecha_pago=$cfdi['FechaPago'];
            $xml_nomina_ss=$cfdi['NumSeguridadSocial'];
            $xml_nomina_curp=$cfdi['CURP'];
        }

        if($contexto['visto']==1){
          $visto='<button id="visto" type="button" class="btn btn-info" data-toggle="modal" data-target="#ver">Visto</button>';
        }else{
          $visto='<button id="visto" type="button" class="btn btn-warning" data-toggle="modal" data-target="#ver" onclick="verArchivo()">No Visto</button>';
        }
        if($contexto['descargado']==1){
          $descarga = '<input type="hidden" name="archivo" value="' . $contexto['nombre_xml'] . '">
            <button type="submit" class="btn btn-info">Descargado</button>';
        }else{
          $descarga = '<input type="hidden" name="archivo" value="' . $contexto['nombre_xml'] . '">
            <button type="submit" class="btn btn-warning">No Descargado</button>';
        }

        echo '<div class="col-sm-8 col-md-6">
                <div class="thumbnail alert-success">
                  <div class="row ">
                    <div class="col-xs-1">
                      <i class="fa fa-code fa-3x"></i>
                    </div>
                    <div class="col-xs-11 text-right">
                      <div class="small"><h4>',$contexto['rfc_receptor'],'</h4></div>
                    </div>
                  </div>
                  <div class="row ">
                    <div class="col-xs-12 text-right">
                      <div class="small"><h5>RFC responsable: ',$contexto['rfc_responsable'],'</h5></div>
                    </div>
                    <div class="col-xs-12 text-right">
                      <div class="small"><h5>Sueldo: $ ',$contexto['sueldo'],' MXN</h5></div>
                    </div>
                    <div class="col-xs-12 text-right">
                      <div class="small"><h5>Fecha de pago: ',$contexto['fecha_pago'],'</h5></div>
                    </div>
                    <div class="col-xs-12 text-right">
                      <div class="small" ><h6 id="xml">',$contexto['nombre_xml'],'</h6></div>
                    </div>

                    <div class="col-xs-12 text-center">
                      <form class="" action="?vista=descargar" method="POST">
                        <p>',$visto,' ',$descarga,'</p>
                      </form>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="ver" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center" id="myModalLabel">Detalles de nomina</h4>
                          </div>
                          <div class="modal-body">
                              <div class="panel-heading alert-info">Datos del Emisor</div>
                              <div class="well well-sm">
                                <dl class="dl-horizontal">
                                  <dt>Nombre:</dt>
                                  <dd>',$xml_emisor_nombre,'</dd>
                                  <dt>RFC:</dt>
                                  <dd>',$xml_emisor_rfc,'</dd>
                                  <dt>País:</dt>
                                  <dd>',$xml_dom_fiscal_pais,'</dd>
                                  <dt>C.P:</dt>
                                  <dd>',$xml_dom_fiscal_cp,'</dd>
                                  <dt>Estado:</dt>
                                  <dd>',$xml_dom_fiscal_estado,'</dd>
                                  <dt>Municipio:</dt>
                                  <dd>',$xml_dom_fiscal_municipio,'</dd>
                                  <dt>Colonia:</dt>
                                  <dd>',$xml_dom_fiscal_colonia,'</dd>
                                </dl>
                              </div>

                              <div class="panel-heading alert-info">Datos del Receptor</div>
                              <div class="well well-sm">
                                <dl class="dl-horizontal">
                                  <dt>Nombre:</dt>
                                  <dd>',$xml_receptor_nombre,'</dd>
                                  <dt>RFC:</dt>
                                  <dd>',$xml_receptor_rfc,'</dd>
                                  <dt>CURP:</dt>
                                  <dd>',$xml_nomina_curp,'</dd>
                                  <dt>No. de seguro social:</dt>
                                  <dd>',$xml_nomina_ss,'</dd>
                                  <dt>Puesto:</dt>
                                  <dd>',$xml_nomina_puesto,'</dd>
                                  <dt>Departamento:</dt>
                                  <dd>',$xml_nomina_dpto,'</dd>
                                </dl>
                              </div>

                              <div class="panel-heading alert-info">Datos de Nomina</div>
                              <div class="well well-sm">
                                <dl class="dl-horizontal">
                                  <dt>Fechas:</dt>
                                  <dd>',$xml_nomina_inicio_pago," al ",$xml_nomina_fin_pago,'','</dd>','
                                  <dt>Fecha de pago:</dt>
                                  <dd>',$xml_nomina_fecha_pago,'</dd>
                                  <dt>Periodicidad de pago:</dt>
                                  <dd>',$xml_nomina_periodicidad,'</dd>
                                  <dt>Días pagados:</dt>
                                  <dd>',$xml_nomina_dias_pagados,'</dd>
                                  <dt>Lugar de expedición:</dt>
                                  <dd>',$xml_comprobante_lugar_expedicion,'</dd>
                                  <dt>Forma de pago:</dt>
                                  <dd>',$xml_comprobante_metodo_de_pago,'</dd>
                                  <dt>Comprobante:</dt>
                                  <dd>',$xml_comprobante_tipo_comprobante,'</dd>
                                  <dt>Sueldo:</dt>
                                  <dd>',$xml_comprobante_sueldo,'</dd>
                                  <dt>Descuento:</dt>
                                  <dd>',$xml_comprobante_descuento,'</dd>
                                  <dt>Subtotal:</dt>
                                  <dd>',$xml_comprobante_subtotal,'</dd>
                                </dl>
                              </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                          </div>
                        </div>
                      </div>

                  <!-- FIN Modal -->

                  </div>
                </div>
              </div>';
    }

    /**
    * @access public
    * @param String
    * $rfc del usuario y su respectivo $permiso
    *
    **/
    public function verArchivos($rfc, $permiso){
      $datos = new Conexion();
      if($permiso==0){
        $sql = $datos->query("SELECT * FROM archivo_empleado WHERE rfc_receptor='$rfc';");
        if($datos->filas($sql)>0){
          $archivos = "";
          while($contexto = $datos->recorrer($sql)){
            $this->crearDetalle($contexto);
          }
        } else {
          echo'<div class="alert alert-info" role="alert"><strong>No existen archivos</strong>, Actualmente.</div>';
        }
      } else if ($permiso==1) {
        $sql = $datos->query("SELECT * FROM archivo_empleado WHERE rfc_responsable='$rfc';");
        if($datos->filas($sql)>0){
        $archivos = "";
          while($contexto = $datos->recorrer($sql)){
            $this->crearDetalle($contexto);
          }
        } else {
          echo'<div class="alert alert-info" role="alert"><strong>No existen archivos</strong>, Actualmente.</div>';
        }

      } else{
          $sql = $datos->query("SELECT * FROM archivo_empleado;");
          if($datos->filas($sql)>0){
          $archivos = "";
            while($contexto = $datos->recorrer($sql)){
              $this->crearDetalle($contexto);
            }
        } else {
          echo'<div class="alert alert-info" role="alert"><strong>No existen archivos</strong>, Actualmente.</div>';
        }
      }
      $datos->liberar($sql);
      $datos->close();
    }
  }
 ?>