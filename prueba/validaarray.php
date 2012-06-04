<form action="ventas.php?a=pack_actualizar" onsubmit="return verificar_tallas_colores()" name="frm_pack_cantidad" id="frm_pack_cantidad" method="post"> 
    <table id="padre"> 
        <tr> 
            <td>Talla -> xx</td> 
            <td><input type="text" name="tal_45_24"  class="input_texto" style="text-align:center" maxlength="2" size="10" onkeypress="return validar_campos(event,/^([0-9])$/)" /></td>    
        </tr> 
        <tr> 
            <td>Talla -> xx</td> 
            <td><input type="text" name="tal_22_1"  class="input_texto" style="text-align:center" maxlength="2" size="10" onkeypress="return validar_campos(event,/^([0-9])$/)" /></td>    
        </tr> 
        <tr> 
            <td>Talla -> xx</td> 
            <td><input type="text" name="tal_89_23"  class="input_texto" style="text-align:center" maxlength="2" size="10" onkeypress="return validar_campos(event,/^([0-9])$/)" /></td>    
        </tr> 
        <tr> 
            <td>Talla -> xx</td> 
            <td><input type="text" name="tal_7_6"  class="input_texto" style="text-align:center" maxlength="2" size="10" onkeypress="return validar_campos(event,/^([0-9])$/)" /></td>    
        </tr> 
    </table> 
    <button type="submit">Envia</button> 
</form> 



<script type="text/javascript"> 
<!-- 

function validar_campos() { 
    return true; 
} 

function verificar_tallas_colores(){ 
    for (var i=0, ele; ele = document.getElementById("padre").getElementsByTagName("input")[i]; i++) 
        if (ele.value == '') { 
            alert('No puede haber campos vacíos'); 
            return false; 
        } 
    return true; 
} 


// --> 
</script>  