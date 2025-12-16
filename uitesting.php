<?php
session_start();
include 'database/database.php';
include 'partials/functions.php'; 
include 'partials/header.php';
include 'partials/linkheader.php';


$error = '';
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UI testing Parts</title>
</head>
<body>
    <!--------
    <section class="new-hero-ui-wrapper">
    <section class="new-hero-ui">
     <div class="new-hero-ui-left">
        <h1>Socrate Tech Institute</h1>
     </div>  
     <div class="new-hero-button-ui">
     <a href="application.html"><button class="button postuler" type="submit">Postuler</button></a>
     </div>
    </section>
    </section>
   ---->

<section class="home-mega-section">
       <div class="title">
       <h1>Education,technologie et Solution réelles</h1> 
       </div>
       <section class="technology-section">
         <div class="tech-grid-element">
         <h2 class="tech-grid-title">Une école pensée pour l'ère numérique</h2>
         </div>
         <div class="title tech-grid-element">
         <h3 class="tech-grid-title">Site web officiel</h3>
         </div>
         <div class="tech-grid-element">
         <h3 class="tech-grid-title">Système de gestion scolaire intégré</h3>
         </div>
         <div class="tech-grid-element">
          <h3 class="tech-grid-title">Portail élèves/parents/enseignants</h3>
         </div>
         <div class="tech-grid-element">           
         </div>      
       </div>
        </section>
        <div class="title">
       <h1>Payez la scolarité via Moncash</h1> 
       </div>
        <section class="moncash-section">
        <div class="moncash-section-element">
         <div class="title">
            <h3 class="moncash-section-text">Paiment sécurisé via Moncash</h3>
         </div>
         <p class="moncash-section-text">Pas besoin de quitter le travail simplement 
            pour verser la scolarité. </p>
            <p class="moncash-section-text">Paie la scolarité en deux clics. </p>
        </div>
        <div class="moncash-section-element">      
        </div>    
        </section>
        <div class="title">
       <h1>Nos Développeurs</h1> 
       </div>
       <div class="basic-info-container ourdevelopers-section"> 
      <div class="tutor-info ourdeveloper">
        <div class="tutor-info-left ourdeveloper-left">
          <img src="images/0016_3.JPG" alt="">
        </div>
        <div class="tutor-info-right ourdeveloper-right">
          <h2>JEAN W. Leyder</h2>
          <h3>Etudiant en Sciences Informatiques à Yuan Ze University</h3>
         <h4>Intérêt en Web développement</h4>
          <strong>Technologies utilisées: HTML,CSS,JS,MySQL,PHP</strong><p></p>
          <div class="contact-info">
           <a href=""><i class="fa-brands fa-facebook"></i></a>
            <a href=""><i class="fa-brands fa-square-instagram"></i></a>
            <a href=""><i class="fa-solid fa-envelope"></i></a>
            <a href=""><i class="fa-brands fa-whatsapp"></i></a>
            <a href=""><i class="fa-brands fa-linkedin"></i></a>
          </div>       
        </div>
       </div>
       <div class="tutor-info ourdeveloper">
        <div class="tutor-info-left ourdeveloper-left">
        <img src="images/0016_3.JPG" alt="">
        </div>
        <div class="tutor-info-right ourdeveloper-right">
        <h2>Darlie Henry</h2>
          <h3>Etudiante en Sciences Informatiques à Yuan Ze University</h3>
        </div>
       </div>
      </div> 
</section>
</section>


    


























    <!------
    <section class="choose-us-container">
       <div class="grid-element-1">
        <div class="grid-element-title">
        <h2>Apprentissage Moderne</h2>
        </div>
          
       </div>
       <div class="grid-element-2">
        <div class="grid-element-title">
        <h2>Collaboration & Communauté</h2>
        </div>
        
       </div>
       <div class="grid-element-3">
        <div class="grid-element-title">
        <h2>Parcours Personnalisé</h2>
        </div>
        
       </div>
       <div class="grid-element-4">
        <div class="grid-element-title">
        <h2>Compétences du Futur</h2> 
        </div>
         <div class="new-technologies-container">
            <div class="new-technologies-container-1">
            <div class="element">
            <img src="images/choose-us/newtech/python.webp" alt="">
            </div>
            <div class="element">
            <img src="images/choose-us/newtech/python.webp" alt="">
            </div>
            <div class="element">
            <img src="images/choose-us/newtech/python.webp" alt="">
            </div>
            <div class="element">
            <img src="images/choose-us/newtech/python.webp" alt="">
            </div>
            </div>

            <div class="new-technologies-container-2">
            <div class="element">
            <img src="images/choose-us/newtech/python.webp" alt="">
            </div>
            <div class="element">
            <img src="images/choose-us/newtech/python.webp" alt="">
            </div>
            <div class="element">
            <img src="images/choose-us/newtech/python.webp" alt="">
            </div>
            <div class="element">
            <img src="images/choose-us/newtech/python.webp" alt="">
            </div>
            </div>

            <div class="new-technologies-container-3">
            <div class="element">
            <img src="images/choose-us/newtech/python.webp" alt="">
            </div>
            <div class="element">
            <img src="images/choose-us/newtech/python.webp" alt="">
            </div>
            <div class="element">
            <img src="images/choose-us/newtech/python.webp" alt="">
            </div>
            <div class="element">
            <img src="images/choose-us/newtech/python.webp" alt="">
            </div>
            </div>

            <div class="new-technologies-container-4">
            <div class="element">
            <img src="images/choose-us/newtech/python.webp" alt="">
            </div>
            <div class="element">
            <img src="images/choose-us/newtech/python.webp" alt="">
            </div>
            <div class="element">
            <img src="images/choose-us/newtech/python.webp" alt="">
            </div>
            <div class="element">
            <img src="images/choose-us/newtech/python.webp" alt="">
            </div>
           </div>       
            </div>   
         </div> 
       </div>
    </section>
    ------>
</body>
</html>