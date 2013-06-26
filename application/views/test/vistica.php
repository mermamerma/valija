

<h1>
    Bienvenido <?= $nombre?>
    
</h1>
<h2>
    Usuario: 
</h2>


<form name="form1" action="<?=base_url()?>test/procesar_vista" method="POST">
    <label>Nombre: </label><input type="text" name="usuario"/>
    <input name="" type="submit" />
</form>
<h2>
    
</h2>


