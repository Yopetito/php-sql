<!-- detailRecette.php
: 2e page : dans laquelle on affichera le détail d'une recettes : es infos (nom, catégorie, temps de préparation) + liste des ingrédients de cette recette -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

try
{
    $mysqlClient = new \PDO('mysql:host=localhost;dbname=recipe;chatset=utf8', 'root', '');
}
catch (Exeption $e)
{
    die('Erreur: ' . $e->getMessage());
}

// $sqlQuery = 'SELECT recette.nom, recette.tempsPreparation, '
// $recipesStatement = $mysqlClient->query($sqlQuery);
// // $recipesStatement = $mysqlClient->prepare($sqlQuery);
// // $recipesStatement->execute();
// $recipes = $recipesStatement->fetchALL();

$recetteId = $_GET['id'];
$sqlQuery = 'SELECT recette.id_recette, recette.nom, recette.tempsPreparation, recette.id_Categorie, categorie.nomCategorie 
            FROM recette
            INNER JOIN categorie ON recette.id_Categorie = categorie.id_Categorie
            WHERE recette.id_recette = :id';
$recipesStatement = $mysqlClient->prepare($sqlQuery);
$recipesStatement->execute(['id' => $recetteId]);
$recipes = $recipesStatement->fetch();

?>
<table>
    <thead>
        <tr>
            <th>Recette</th>
            <th>Temps de preparation</th>
            <th>Catégorie</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $recipes['nom']; ?></th>
            <td><?php echo $recipes['tempsPreparation']; ?></td>
            <td><?php echo $recipes['nomCategorie']; ?></td>
        </tr>
    </tbody>
</table>
</body>
</html>