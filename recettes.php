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

$sqlQuery = 'SELECT recette.id_recette, recette.nom, recette.tempsPreparation, categorie.nomCategorie
            FROM recette
            INNER JOIN categorie ON recette.id_Categorie = categorie.id_Categorie';
$recipesStatement = $mysqlClient->query($sqlQuery);
// $recipesStatement = $mysqlClient->prepare($sqlQuery);
// $recipesStatement->execute();
$recipes = $recipesStatement->fetchALL();
?>
<table border = 1>
    <thead>
        <tr>
            <th>Recette</a></th>
            <th>Temps de preparation</th>
            <th>Catégorie</th>  
        </tr>
    <tbody>
<?php foreach ($recipes as $recipe) { ?>
        <tr>
            <td><a href="details.php?id=<?php echo $recipe['id_recette']?>"> <?php echo $recipe['nom']; ?> </a></th>
            <td><?php echo $recipe['tempsPreparation']; ?></td>
            <td><?php echo $recipe['nomCategorie']; ?></td>
        </tr>
<?php
}
?>
    </tbody>
</table>
    
</body>
</html>