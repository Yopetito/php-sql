<!-- detailRecette.php
: 2e page : dans laquelle on affichera le détail d'une recettes : es infos (nom, catégorie, temps de préparation) + liste des ingrédients de cette recette -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<?php

try
{
    $mysqlClient = new \PDO('mysql:host=localhost;dbname=recipe;chatset=utf8', 'root', 'Jifomeye1207');
}
catch (Exeption $e)
{
    die('Erreur: ' . $e->getMessage());
}

$recetteId = $_GET['id'];
$idrecipe = (isset($_GET["id"])) ? $_GET["id"] : null;
if($idrecipe) {
    $sqlQueryRecette = 'SELECT recette.id_recette, recette.nom, recette.tempsPreparation, recette.id_Categorie, categorie.nomCategorie 
        FROM recette
        INNER JOIN categorie ON recette.id_Categorie = categorie.id_Categorie
        WHERE recette.id_recette = :id';
    $recipesStatement = $mysqlClient->prepare($sqlQueryRecette);
    $recipesStatement->execute(['id' => $recetteId]);
    $recipes = $recipesStatement->fetch();

    $sqlQueryIngredients = 'SELECT recette.id_recette, ingredient.nomIngredient, miseenplace.qttIngredient, miseenplace.uniteDeMesure
        FROM recette
        INNER JOIN miseenplace
        ON recette.id_recette = miseenplace.id_recette
        INNER JOIN ingredient
        ON miseenplace.id_ingredient = ingredient.id_ingredient
        WHERE recette.id_recette = :id';
    $recipesIngredients = $mysqlClient->prepare($sqlQueryIngredients);
    $recipesIngredients->execute(['id' => $recetteId]);
    $recipesings = $recipesIngredients->fetchALL();
}

?>

<h2>Recette: <?php echo $recipes['nom']."<br>";?> </h2>
<p>Tempes de Preparation : <?php echo $recipes['tempsPreparation']." Minutes"; ?></p>
<p>Catégorie: <?php echo $recipes['nomCategorie']."<br>"; ?></p>
<p>Ingredients:</p>
<table border = 1>
    <tbody>
        <?php foreach($recipesings as $recipesing) {?>
        <tr>
            <td><?php echo $recipesing['nomIngredient']; ?></td>
            <td><?php echo $recipesing['qttIngredient']." ".$recipesing['uniteDeMesure']; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</body>
</html>