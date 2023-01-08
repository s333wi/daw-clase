
# CSM Project

  

Hi han un parell de coses que vull comentar sobre el codi del projecte.

  

## Com extrec el $\_POST

  

```

  

$data = filter_input_array(INPUT_POST);

  

extract($data);

  

```

  

En primer lloc, s'aplica un filtre al `$_POST` i després es guarda el resultat a la variable `$data`. Finalment, es fa servir la funció `extract` per treure totes les variables de `$data` que són del tipus `$key=>$value`, com si fos una còpia del `$_POST`. Això facilita l'ús de les dades rebudes per la funció, ja que es poden accedir a elles directament com a variables locals. Per mi aquesta manera es la més senzilla ja que no has de hardcodejar cada variable de `$_POST` individualment.

  

## La funcio save()

  
La funció ***save()*** permet realitzar tant insercions com actualitzacions tant d'usuaris com de notícies de manera senzilla. Aquesta decisió s'ha pres amb la finalitat de simplificar el codi i millorar la mantenibilitat del sistema. La única diferencia entre ambes operacions radica en la presència o ausència d'un identificador. Així doncs, en cas de realitzar una inserció, no serà necessari proporcionar un identificador, mentre que en cas de realitzar una actualització sí que serà necessari proporcionar un identificador vàlid.
