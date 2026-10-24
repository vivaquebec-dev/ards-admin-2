<h1>Bienvenue sur le site Au Royaume des sons</h1>

<p>

    Votre compte est maintenant activé

</p>

<p>

    Gestion des licences : <a href="https://administration.auroyaumedessons.com">https://administration.auroyaumedessons.com</a>

    <br />

    Nombre de licences achetées : <?php echo $nombre_licence; ?>

    <br />

    Nom d'utilisateur : <?php echo $nom_utilisateur; ?>

    <br />

    Mot de passe : <?php echo $mot_de_passe; ?>

    <br />

</p>

<?php

	if ($type_licence==3 || $type_licence==4) {

		echo '<h3>Procédure de gestion</h3>';

		echo '<h4>Écoles</h4>';

		echo '<p>L\'administrateur de l\'école doit créer les «accès professeurs/professionnels» et distribuer les licences à chacun d\'eux. <br />

		- Nom professeur <br />

		- Prénom professeur <br />

		- Courriel professeur <br />

		- Lien avec l\'école <br />

		- Nombre de licences allouées <br />

		- Nom d\'utilisateur – attribué par l\'admin <br />

		- Mot de passe – attribué par l\'admin <br />

		</p>';

		echo '<h4>Professeurs / Professionnel</h4>';

		echo '<p>Le professeur/professionnel doit créer les «accès élèves». Il enregistre lui-même les mots de passe. Le seul champ modifiable est le mot de passe. <br />

		- Nom l\'élève<br />

		- Prénom l\'élève<br />

		- Sexe de l\'élève<br />

		- Lien avec le prof<br />

		- Nom d\'utilisateur – attribué par le prof<br />

		- Mot de passe – attribué par le prof

		</p>';

		echo '<h4>Tableau des Résultats</h4>';

		echo '<p>Accessible par les professeurs/professionnels. <br />Tous les résultats sont enregistrés.</p>';

	} elseif ($type_licence==5) {

		echo '<p style="color:#F00;">Votre nom d\'utilisateur et votre mot de passe vous permettent d\'accéder au jeu et à l\'administration pour y inscrire vos élèves et 

		consulter le tableau de progression de votre classe.</p>';

		echo '<p>Accès au jeu : <a href="https://jeu.auroyaumedessons.com">https://jeu.auroyaumedessons.com</a></p>';

		

		echo '<h3>Procédure de gestion</h3>';

		echo '<h4>Professeurs / Professionnel</h4>';

		echo '<p>Le professeur/professionnel doit créer les «accès élèves». Il enregistre lui-même les mots de passe. Le seul champ modifiable est le mot de passe. <br />

		- Nom l\'élève<br />

		- Prénom l\'élève<br />

		- Sexe de l\'élève<br />

		- Lien avec le prof<br />

		- Nom d\'utilisateur – attribué par le prof<br />

		- Mot de passe – attribué par le prof

		</p>';

		echo '<h4>Tableau des Résultats</h4>';

		echo '<p>Accessible par les professeurs/professionnels. <br />Tous les résultats sont enregistrés.</p>';

		

		echo '<h3>INFORMATIONS IMPORTANTES:</h3>

		<p>Prenez note que vous devez jouer avec <strong>Google Chrome</strong> ou <strong>Firefox</strong>.</p>

		<p>Pour l\'utilisation de la tablette, les temps de téléchargements peuvent varier selon la vitesse de votre connexion internet. </p>

		<p>Il est fortement suggéré de compléter l\'application "Au royaume des sons" en grand groupe sur TNI avec votre accès enseignant avant de permettre à l\'élève de s\'exercer avec son code personnalisé.</p>

		<p>L\'élève qui joue avec son code doit suivre la progression du jeu, mais l\'enseignant peut se déplacer à sa guise en allant dans MENU / MA MISSION / Choisir son étoile.</p>';

	}

?>

<p>

    Nous vous remercions encore une fois de votre achat

    <br />

    <br />

    <strong>L'équipe Au Royaume des sons</strong>

</p>