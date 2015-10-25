<?php
/**
 * Created by PhpStorm.
 * User: moribus
 * Date: 25/10/2015
 * Time: 14:58
 */ ?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Test du calcul d'itinéraire</title>
</head>
<body>
    <div id="InterfaceCalculItineraire">
        <form action="index.php" method="post">
            <span id="spanDepart">
                <label>
                    Sélectionner le départ :
                    <select name="depart">
                        <?php
                        foreach ($destinations as $destination):?>
                        <option value="<?php echo $destination['nom']; ?>"><?php echo $destination['nom']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </span>

            <span id="spanArrivee">
                <label>
                    Sélectionner l'arrivée :
                    <select name="arrivee">
                        <?php
                        foreach ($destinations as $destination):?>
                            <option value="<?php echo $destination['nom']; ?>"><?php echo $destination['nom']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </span>
            <input type="submit" value="Calculer l'itinéraire" />
        </form>
    </div>
</body>
</html>