<?php
session_start();
include 'database/database.php';
include 'partials/functions.php'; 
include 'partials/header.php';

$error = '';
?>

    <?php  include 'partials/linkheader.php';?>
    <section class="new-hero-ui-wrapper">
    <section class="new-hero-ui">
     <div class="new-hero-ui-left">
        <h1>Socrate Tech Institute</h1>
     </div>  
     <!--------
     <div class="new-hero-button-ui">
     <a href="admission/application.php"><button class="button postuler" type="submit">Apply</button></a>
     </div>
     ------>
    </section>
    </section>
    
    
    <!-----
    <section class="bg-main-container">
    <section class="hero">
      <div class="icon-background">
        <i class="fas fa-code"></i>
        <i class="fas fa-dna"></i>
        <i class="fas fa-brain"></i>
        <i class="fas fa-laptop-code"></i>
        <i class="fas fa-atom"></i>
        <i class="fas fa-book"></i>
        <i class="fas fa-calculator"></i>
        <i class="fas fa-microchip"></i>
        <i class="fas fa-flask"></i>
        <i class="fas fa-network-wired"></i>
        <i class="fas fa-globe"></i>
        <i class="fas fa-chalkboard-teacher"></i>
        <i class="fas fa-graduation-cap"></i>
        <i class="fas fa-lightbulb"></i>
        <i class="fas fa-square-root-variable"></i>
        <i class="fas fa-vials"></i>
        <i class="fas fa-seedling"></i>
        <i class="fas fa-wifi"></i>
        <i class="fas fa-terminal"></i>
        <i class="fas fa-head-side-brain"></i>
      </div>
      
      
      <div class="hero-left">
          <h1>Socrate Tech Institute</h1>
          <div class="subtitled-wrapper">
              <p class="subtitle1"><span>Classical education</span> and <span>innovation serving</span> a new Haiti.</p>
              <p class="subtitle2">A <span>modern</span> secondary school that trains responsible young citizens, capable of <span>taking action</span>, <span>creating</span>, <span>innovating</span>, and <span>understanding</span> their country.</p>
             <div class="hero-button-wrapper">
              <a href="application.html"><button class="button postuler" type="submit">Apply</button></a>
               <button class="button explorer">Explore</button>
               
             </div>
          </div>
      </div>
      <div class="hero-right">
          <img src="images/hero-image.png" alt="">
      </div>
    </section>
    </section>
    ---->
  


    <main>
 
    <section class="explore-tab-ui">
      <div class="title">
      <h1>Campus Life</h1>
      </div>

      


  <div class="tabs">
    <button class="tabs-buttons btn-active" data-tab="1">Facilities</button>
    <button class="tabs-buttons" data-tab="2">Laboratories</button>
    <button class="tabs-buttons" data-tab="3">Sports Areas</button>
    <button class="tabs-buttons" data-tab="4">Gym & Relaxation</button>
  </div>

  <div class="tabs-content tabs-content-active campusgrid-container" data-tab="1">
  <div class="campus-grid-item">
  <img src="/images/tabUIImages/building/batimentacademique.jpg" alt="">
  </div>
  <div class="campus-grid-item">
  <img src="/images/tabUIImages/building/library2.jpg" alt="">
  </div>
  <div class="campus-grid-item">
  <img src="/images/tabUIImages/building/salled'etude.jpg" alt="">
  </div>
  <div class="campus-grid-item">
  <img src="/images/tabUIImages/building/building2.jpg" alt="">
  </div>
  </div>

  <div class="tabs-content campusgrid-container" data-tab="2">
  <div class="campus-grid-item">
  <img src="/images/tabUIImages/building/classroom1.jpg" alt="">
  </div>
  <div class="campus-grid-item">
  <img src="/images/tabUIImages/building/salled'etude.jpg" alt="">
 </div>
 <div class="campus-grid-item">
 <img src="/images/tabUIImages/building/salledediscussion.jpg" alt="">
 </div>
 <div class="campus-grid-item">
 <img src="/images/tabUIImages/building/salledeconference.jpg" alt="">
 </div>
  </div>

  <div class="tabs-content campusgrid-container" data-tab="3">
  <div class="campus-grid-item">
  <img src="/images/tabUIImages/sport/terrainfootball.jpg" alt="">
</div>
<div class="campus-grid-item">
<img src="/images/tabUIImages/sport/terrainfutsal.jpg" alt="">
</div>
<div class="campus-grid-item">
<img src="/images/tabUIImages/sport/terrainvolleyball.png" alt="">
</div>
<div class="campus-grid-item">
<img src="/images/tabUIImages/sport/terrainbasket.webp" alt="">
</div>

  



  </div>

  <div class="tabs-content campusgrid-container" data-tab="4">
  <div class="campus-grid-item">
  <img src="/images/tabUIImages/sport/gym.jpg" alt="">
</div>
<div class="campus-grid-item">
<img src="/images/tabUIImages/sport/parcdedetente.jpg" alt="">
</div>
<div class="campus-grid-item">
<img src="/images/tabUIImages/sport/espaceconcert.jpg" alt="">
</div>
<div class="campus-grid-item">
<img src="/images/tabUIImages/building/library2.jpg" alt="">
</div>

  </div>
</section>

        <div class="title">
        <h1 style="text-align:center;">Why Choose Us?</h1>
        </div>

      <section class="choose-us-container">
       <div class="grid-element-1">
        <div class="grid-element-title">
        <h2>Modern Learning</h2>
        </div>
          
       </div>
       <div class="grid-element-2">
        <div class="grid-element-title">
        <h2>Collaboration & Community</h2>
        </div>
        
       </div>
       <div class="grid-element-3">
        <div class="grid-element-title">
        <h2>Personalized Pathway</h2>
        </div>
        
       </div>
       <div class="grid-element-4">
        <div class="grid-element-title">
        <h2>Future Skills</h2> 
        </div>
         
       </div>
    </section>

<!------
      <section class="why-choose-us">
        <h1 class="choose-title">Why Choose Us</h1>
      
        <div class="why-choose-us-element">
          <i class="fas fa-graduation-cap"></i>
          <div class="text-block">
            <h2>Education built for the future</h2>
            <p>We prepare students for tomorrow’s challenges with courses that integrate technology, critical thinking, and creativity.</p>
          </div>
        </div>
      
        <div class="why-choose-us-element">
          <i class="fas fa-user-check"></i>
          <div class="text-block">
            <h2>A personalized learning approach</h2>
            <p>Every student is unique. We adapt our approach to encourage independence, collaboration, and individual progress.</p>
          </div>
        </div>
      
        <div class="why-choose-us-element">
          <i class="fas fa-globe"></i>
          <div class="text-block">
            <h2>An open mindset to the world</h2>
            <p>English, digital skills, and general culture: our students develop the skills to thrive in a globalized world.</p>
          </div>
        </div>
      
        <div class="why-choose-us-element">
          <i class="fas fa-school"></i>
          <div class="text-block">
            <h2>Modern facilities</h2>
            <p>Our spaces are designed to support active learning: labs, libraries, relaxation areas, and more.</p>
          </div>
        </div>
      
        <div class="why-choose-us-element">
          <i class="fas fa-rocket"></i>
          <div class="text-block">
            <h2>A launchpad for success</h2>
            <p>Internships, projects, and guidance: we train young people who are ready to enter the professional world and innovate.</p>
          </div>
        </div>
      </section>
       

      <section class="filieres-wrapper">
        <h1>Academic Tracks & Modern Professional Courses</h1>
        <div class="table-container">
          <table class="table">
            <thead>
              <tr>
                <th>Track</th>
                <th>Track Objective</th>
                <th>Associated Modern & Professional Courses</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td data-label="Track">Mathematics & Physics Sciences (SMP)</td>
                <td data-label="Track Objective">
                  Train logical and analytical minds capable of solving complex problems in scientific and technological fields.
                </td>
                <td data-label="Associated Modern & Professional Courses">
                  <ul>
                    <li>Web Programming</li>
                    <li>Problem Solving</li>
                    <li>Artificial Intelligence</li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td data-label="Track">Life & Earth Sciences (SVT)</td>
                <td data-label="Track Objective">
                  Develop a deep understanding of living systems and natural phenomena to prepare for scientific or medical careers.
                </td>
                <td data-label="Associated Modern & Professional Courses">
                  <ul>
                    <li>First Aid</li>
                    <li>Introduction to Artificial Intelligence</li>
                    <li>Digital Skills</li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td data-label="Track">Economic & Social Sciences (SES)</td>
                <td data-label="Track Objective">
                  Introduce students to economic, social, and political mechanisms to understand and act in the modern world.
                </td>
                <td data-label="Associated Modern & Professional Courses">
                  <ul>
                    <li>Entrepreneurship</li>
                    <li>Civic Education</li>
                    <li>Digital Culture</li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td data-label="Track">Literature, Languages & Arts (LLA)</td>
                <td data-label="Track Objective">
                  Cultivate expression, critical analysis, creativity, and cultural openness through languages, literature, and the arts.
                </td>
                <td data-label="Associated Modern & Professional Courses">
                  <ul>
                    <li>Civic Education & Leadership with the reintegration of the book “J’aime Haïti”</li>
                    <li>Digital Communication</li>
                  </ul>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
      <div class="comment-postuler-title">
        <h1>Ready to Join Us? Here’s How!</h1>
      </div>
   
      <section class="commentpostuler">
       
        <div class="commentpostuler-element">
          <div class="check"><i class="fa-solid fa-check"></i></div>
          <span>1</span>
          <p>Fill out the online registration form</p>
          <div class="line"></div>
        </div>
      
        <div class="commentpostuler-element">
          <div class="check"><i class="fa-solid fa-check"></i></div>
          <span>2</span>
          <p>Take the entrance exams</p>
          <div class="line"></div>
        </div>
      
        <div class="commentpostuler-element">
          <div class="check"><i class="fa-solid fa-check"></i></div>
          <span>3</span>
          <p>Motivation interview</p>
          <div class="line"></div>
        </div>
      
        <div class="commentpostuler-element">
          <div class="check"><i class="fa-solid fa-check"></i></div>
          <span>4</span>
          <p>Submit required documents</p>
          <div class="line"></div>
        </div>
      
        <div class="commentpostuler-element">
          <div class="check"><i class="fa-solid fa-check"></i></div>
          <span>5</span>
          <p>Complete enrollment</p>
        </div>
      </section>
        ------>
    

      <section class="testimonials-wrapper">
        <div class="title">
        <h1>Trusted Testimonials</h1>
        </div>
          
          <p class="testimonial-paragraph">At SocrateTech, every voice matters. Discover what our students and parents think about our modern and human-centered educational approach. <br>Their experiences are our strongest proof of impact.</p>
        <div class="testimonial-container">
          <div class="testimonial-element">

          <div class="testimonial-top">     
            <img src="/images/testimonial/testimonial1.jpg" alt="">
          </div>
          <div class="testimonial-text">
            <p><i class="fa-solid fa-quote-left"></i>What I love most about SocrateTech is the way we learn. We work on real projects, and it motivates me to give my best every day.<i class="fa-solid fa-quote-right"></i></p>
            <div class="extra-student-info">
              <h2>Lauriane M.</h2>
            <p>NS2 Student</p>
            </div>
          </div> 
        </div>
        <div class="testimonial-element">

          <div class="testimonial-top">     
            <img src="/images/testimonial/testimonial2.png" alt="">
          </div>
          <div class="testimonial-text">
            <p><i class="fa-solid fa-quote-left"></i>Thanks to the practical workshops, I gained confidence and learned how to collaborate better. SocrateTech helps me improve every day in a motivating environment.<i class="fa-solid fa-quote-right"></i></p>
            <div class="extra-student-info">
              <h2>Naomi B.</h2>
            <p>NS3 Student</p>
            </div>
          </div> 
         
          
        </div>

        <div class="testimonial-element">

          <div class="testimonial-top">     
            <img src="/images/testimonial/testimonial2.png" alt="">
          </div>
          <div class="testimonial-text">
            <p><i class="fa-solid fa-quote-left"></i>Thanks to the practical workshops, I gained confidence and learned how to collaborate better. SocrateTech helps me improve every day in a motivating environment.<i class="fa-solid fa-quote-right"></i></p>
            <div class="extra-student-info">
              <h2>Naomi B.</h2>
            <p>NS3 Student</p>
            </div>
          </div> 
      </div>
        <div class="testimonial-element">

          <div class="testimonial-top">     
            <img src="/images/testimonial/testimonial3.jpg" alt="">
          </div>
          <div class="testimonial-text">
            <p><i class="fa-solid fa-quote-left"></i>Thanks to team projects and modern courses, I discover my potential every day. SocrateTech encourages me to believe in myself and aim higher.<i class="fa-solid fa-quote-right"></i></p>
            <div class="extra-student-info">
              <h2>Sabrina L.</h2>
            <p>NS1 Student</p>
            </div>
          </div>   
        </div>  
        </div>
      </section>

<!------------Mega Section Part----------->
<section class="home-mega-section">
       <div class="title home-mega-main-title">
       <h1>Education, Technology, and Real Solutions</h1> 
       </div>
       <section class="technology-section">
         <div class="tech-grid-element">
         <h2 class="tech-grid-title">A school designed for the digital era</h2>
         </div>
         <div class="title tech-grid-element">
         <h3 class="tech-grid-title">Official website</h3>
         </div>
         <div class="tech-grid-element">
         <h3 class="tech-grid-title">Integrated management system</h3>
         </div>
         <div class="tech-grid-element">
          <h3 class="tech-grid-title">Portals</h3>
         </div>
         <div class="tech-grid-element">           
         </div>      
       </div>
        </section>
        <div class="title">
       <h1>Pay tuition via MonCash</h1> 
       </div>
        <section class="moncash-section">
        <div class="moncash-section-element">
         <div class="title">
            <h2 class="moncash-section-text">Secure payment via MonCash</h2>
         </div>
        </div>
        <div class="moncash-section-element">      
        </div>    
        </section>
        <!------
        <div class="title">
       <h1>Our Developers</h1> 
       </div>
       <div class="basic-info-container ourdevelopers-section"> 
      <div class="tutor-info ourdeveloper">
        <div class="tutor-info-left ourdeveloper-left">
          <img src="/images/0016_3.JPG" alt="">
        </div>
        <div class="tutor-info-right ourdeveloper-right">
          <h2>JEAN W. Leyder</h2>
          
         <h4>Interest in Web Development</h4>
          <strong>Technologies used: HTML, CSS, JS, MySQL, PHP</strong><p></p>
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
          <img src="/images/0016_3.JPG" alt="">
        </div>
        <div class="tutor-info-right ourdeveloper-right">
          <h2>JEAN W. Leyder</h2>
          
         <h4>Interest in Web Development</h4>
          <strong>Technologies used: HTML, CSS, JS, MySQL, PHP</strong><p></p>
          <div class="contact-info">
           <a href=""><i class="fa-brands fa-facebook"></i></a>
            <a href=""><i class="fa-brands fa-square-instagram"></i></a>
            <a href=""><i class="fa-solid fa-envelope"></i></a>
            <a href=""><i class="fa-brands fa-whatsapp"></i></a>
            <a href=""><i class="fa-brands fa-linkedin"></i></a>
          </div>       
        </div>
       </div>
       ------->
       
</section>
</section>
      <section class="ourpartners-wrapper">
        <div class="title">
        <h1>A Strong Network of Partners</h1>
        </div>
        
        <p>SocrateTech Institute is proud to collaborate with prestigious institutions that share our vision of modern, inclusive, and future-oriented education. These partnerships strengthen our impact on Haitian youth and support our commitment to providing high-quality training grounded in the needs of the professional world and society.</p>
        <div class="ourpartners-container">
          <figure class="ourpartners-element"><img src="/images/testimonial/codingnobg.png" alt=""></figure>
          <figure class="ourpartners-element"><img src="/images/testimonial/sogebanknobg.png" alt=""></figure>
          <figure class="ourpartners-element"><img src="/images/testimonial/digicelnobg.png" alt=""></figure>
          <figure class="ourpartners-element"> <img src="/images/testimonial/henridesnobg.png" alt=""></figure>
          <figure class="ourpartners-element"><img src="/images/testimonial/fokalnobg.png" alt=""></figure>
          <figure class="ourpartners-element"><img src="/images/testimonial/brananobg.png" alt=""></figure>
          <figure class="ourpartners-element"><img src="/images/testimonial/menfpnobg.png" alt=""></figure>
          <figure class="ourpartners-element"><img src="/images/testimonial/bnhnobg.png" alt=""> </figure>
                    
        </div>
      </section>
      <section class="chatbot-main-container">
    <div id="chat-bubble">
      <img src="/images/bot.png" alt="Chatbot" id="bot-icon">
   </div>
 
   <div id="chat-window">
     <div id="top-chat-window"> 
       <img src="/images/bot.png" alt="Chatbot" id="bot-icon-top">
       <h2>AI Assistant</h2>
       
     </div>
     <button id="back_button"></button>
    <div id="faq-buttons">
   <button class="faq-btn" data-category="account">General Account & Access</button>
   <button class="faq-btn" data-category="courses">Courses & Enrollment</button>
   <button class="faq-btn" data-category="fees">Fees & Payments</button>
   <button class="faq-btn" data-category="exams">Exams & Assessments</button>
   <button class="faq-btn" data-category="support">Communication & Support</button>
    </div>
    <div id="sub-questions"></div>
     <div id="chat-messages"><div class="sender-message"></div>
 
   </div>
     <div id="chat-input">
       <input type="text" id="user-input" placeholder="Ask me anything..." />
       <button id="send-btn">Send</button>
     
     </div>
     
   </div>
  </section>
    </main>











    <section class="footer-wrapper">
    <footer class="footer">
      <section class="footer-top">
        <h1>Connected to Inspire and Educate</h1>
          <div class="logo-container">
            <a href="index.html"><img src="/images/logowhite.png" alt=""></a>
          </div>
          <div class="social-media-container">
            <a href=""><i class="fa-brands fa-facebook"></i></a>
            <a href=""><i class="fa-brands fa-square-instagram"></i></a>
            <a href=""><i class="fa-solid fa-envelope"></i></a>
            <a href=""><i class="fa-solid fa-phone"></i></a>
            <a href=""><i class="fa-brands fa-square-x-twitter"></i></a>
            <a href=""><i class="fa-brands fa-linkedin"></i></a>
          </div>
      </section>
      <section class="footer-body">
        <div class="links-container">
          <div class="title">
          <h2>Home</h2>
          </div>
        
          <a href="">Overview</a>
          <a href="">Why SocrateTech?</a>
          <a href="">Testimonials</a>
          <a href="">Our Partners</a>
        </div>

        <div class="links-container">
        <div class="title">
        <h2>Classes & Courses</h2>
          </div>
          
          <a href="">Academic Tracks</a>
          <a href="">Modern Courses</a>
          <a href="">Agriculture & AI</a>
          <a href="">Summer Courses / Club</a>
        
        </div>
        <div class="links-container">
          <div class="title">
          <h2>Enrollment</h2>
          </div>
          
          <a href="">How to enroll?</a>
          <a href="">Entrance exams</a>
          <a href="">Required documents</a>
          <a href="">Financial aid</a>
        </div>
     
        <div class="links-container">
          <div class="title">
          <h2>Contact</h2>
          </div> 
          
          <div class="links-container-contact"> 
            <a href="">Carrefour, Haiti</a></div>
          <div class="links-container-contact">
            <a href="">+509 45 67 89 00</a></div>
          <div class="links-container-contact">
            <a href="">info@socratetech.edu.ht</a></div>
          <div class="links-container-contact">
            <a href="">Mon–Fri, 8 AM – 4 PM</a></div>
             
        </div>
      </section>
      <section class="footer-end">
        <p><i class="fa-regular fa-copyright"></i> 2025 SocrateTech Institute. All rights reserved.</p>
        
      </section>
    </footer>
  </section>

  
  







 


  
      <script>
document.addEventListener("DOMContentLoaded", () => {
  const tabButtons = document.querySelectorAll(".tabs-buttons");
  const tabContents = document.querySelectorAll(".tabs-content");
  if (!tabButtons.length || !tabContents.length) return;

  tabButtons.forEach((button) => {
    button.addEventListener("click", (e) => {
      e.preventDefault();

      const currentTab = button.dataset.tab;

      tabButtons.forEach((btn) => btn.classList.remove("btn-active"));
      tabContents.forEach((content) =>
        content.classList.remove("tabs-content-active")
      );

      button.classList.add("btn-active");
      const activeContent = document.querySelector(
        `.tabs-content[data-tab="${currentTab}"]`
      );
      if (activeContent) activeContent.classList.add("tabs-content-active");
    });
  });
});
      </script> 
  
<script src="js/script.js"></script>
<script src="chatbot_folder/scriptChat.js"></script>
<script src="server.js"> </script>

<?php include 'partials/footer.php'?>
