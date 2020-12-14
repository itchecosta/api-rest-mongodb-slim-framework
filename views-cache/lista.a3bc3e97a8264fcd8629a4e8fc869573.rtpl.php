<?php if(!class_exists('Rain\Tpl')){exit;}?>
<body>
    
    <div class="container">
        <div class="row">
            <table id="example" class="display">
                <legend><h5>Lista de cidades</h5>
                </legend>
                <thead>
                    <tr>
                        <th>Cidade</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $counter1=-1;  if( isset($cidades) && ( is_array($cidades) || $cidades instanceof Traversable ) && sizeof($cidades) ) foreach( $cidades as $key1 => $value1 ){ $counter1++; ?>
                        
                    <tr>
                        <td><?php echo htmlspecialchars( $value1["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td><?php echo htmlspecialchars( $value1["estadoid"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        
                    </tr>
                    <?php } ?>
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th>Cidade</th>
                        <th>Estado</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
